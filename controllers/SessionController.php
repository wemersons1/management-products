<?php

namespace app\controllers;

use app\models\User;
use Yii;

class SessionController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors() {
        $behaviors = parent::behaviors();
    
        $behaviors['authenticator'] = [
            'class' => \kaabar\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
            ],
        ];
    
        return $behaviors;
    }

    public function actionLogin()
    {
        $data = Yii::$app->request->getBodyParams();
        $user = User::findOne([
            'login' => $data['login'],
        ]);

        if(Yii::$app->getSecurity()->validatePassword($data['password'], $user->password)) {
            $token = $this->generateJwt($user);
            
            return [
                'token' => (string) $token,
            ];
        } 
    }

    private function generateJwt(\app\models\User $user) {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
    
        //use DateTimeImmutable;
        $now   = new \DateTimeImmutable();
        
        $jwtParams = Yii::$app->params['jwt'];
    
        $token = $jwt->getBuilder()
            // Configures the issuer (iss claim)
            ->issuedBy($jwtParams['issuer'])
            // Configures the audience (aud claim)
            ->permittedFor($jwtParams['audience'])
            // Configures the id (jti claim)
            ->identifiedBy($jwtParams['id'], true)
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify($jwtParams['request_time']))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify($jwtParams['expire']))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $user->id)
            // Builds a new token
            ->getToken($signer, $key);

        return $token->toString();
    }
    
    /**
     * @throws yii\base\Exception
    */
    private function generateRefreshToken(\app\models\User $user, \app\models\User $impersonator = null): \app\models\UserRefreshToken {
        $refreshToken = Yii::$app->security->generateRandomString(200);
    
        // TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
        $userRefreshToken = new \app\models\UserRefreshToken([
            'urf_userID' => $user->id,
            'urf_token' => $refreshToken,
            'urf_ip' => Yii::$app->request->userIP,
            'urf_user_agent' => Yii::$app->request->userAgent,
            'urf_created' => gmdate('Y-m-d H:i:s'),
        ]);
        if (!$userRefreshToken->save()) {
            throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: '. $userRefreshToken->getErrorSummary(true));
        }
    
        // Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'refresh-token',
            'value' => $refreshToken,
            'httpOnly' => true,
            'sameSite' => 'none',
            'secure' => true,
            'path' => '/v1/auth/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
        ]));
    
        return $userRefreshToken;
    }

    public function actionRefreshToken() {

        $refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
        if (!$refreshToken) {
            return new \yii\web\UnauthorizedHttpException('No refresh token found.');
        }
    
        $userRefreshToken = \app\models\UserRefreshToken::findOne(['urf_token' => $refreshToken]);
    
        if (Yii::$app->request->getMethod() == 'POST') {
            // Getting new JWT after it has expired
            if (!$userRefreshToken) {
                return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
            }
    
            $user = \app\models\User::find()  //adapt this to your needs
                ->where(['userID' => $userRefreshToken->urf_userID])
                ->andWhere(['not', ['usr_status' => 'inactive']])
                ->one();
            if (!$user) {
                $userRefreshToken->delete();
                return new \yii\web\UnauthorizedHttpException('The user is inactive.');
            }
    
            $token = $this->generateJwt($user);
    
            return [
                'status' => 'ok',
                'token' => (string) $token,
            ];
    
        } elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Logging out
            if ($userRefreshToken && !$userRefreshToken->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }
    
            return ['status' => 'ok'];
        } else {
            return new \yii\web\UnauthorizedHttpException('The user is inactive.');
        }
    }
}
