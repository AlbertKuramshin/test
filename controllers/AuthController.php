<?
namespace app\controllers;
use app\models\User;
use app\models\LoginForm;
use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
	 
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('/site/login', [
            'model' => $model,
        ]);
    }

    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest()
    {
    	$user = User::findOne(1);
    	Yii::$app->user->logout();

    	if(Yii::$app->user->isGuest)
    	{
			echo'Пользователь кость';
    	}else {
    		echo'Пользователь авторизован';
    	} 

    }
}