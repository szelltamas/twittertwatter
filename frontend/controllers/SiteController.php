<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;
use frontend\models\AddpostForm;
use yii\web\UploadedFile;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
     public function actionSignup()
         {
           $model = new SignupForm();
  if ($model->load(Yii::$app->request->post())) {

      if ($user = $model->signup()) {

          if (Yii::$app->getUser()->login($user)) {
              return $this->goHome();
          }
      }
  }

  return $this->render('signup', [
      'model' => $model,
  ]);
    }





    public function actionTwatting()
    {
      return $this->render('twatting');
    }

    public function actionImageupload()
    {
      $model = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
          $imageName = "frontend/web/profilimages/".Yii::$app->user->username;
          $model->uploadimage = UploadedFile::getInstance($model, 'uploadimage');
          $model->uploadimage->saveAs($imageName.".".$model->uploadimage->extension);

          $model->update($imageName.".".$model->uploadimage->extension);
          return $this->redirect("index.php?r=site%2Fprofil");
        }
      return $this->render('imageupload', ['model'=> $model]);

    }

    public function actionDeleteimage()
    {
      $model = new UploadForm();


      if ($model->getdata()[0]['avatar'] != 'frontend/web/profilimages/default/default.jpg') {unlink($model->getdata()[0]['avatar']);}
      $model->update('frontend/web/profilimages/default/default.jpg');
      return $this->redirect("index.php?r=site%2Fprofil");
    }



    public function actionDeletepost($id)
    {
      $conn = Yii::$app->db;
      $execute = $conn->createCommand("DELETE FROM post WHERE id='$id'");
      $execute->query();
      return $this->goHome();
    }

    public function actionProfil()
    {
      return $this->render('profil');
    }

    public function actionTwatts($id)
    {
      return $this->render('twatts', ['id'=>$id]);
    }

    public function actionGeneral_profil($nev)
    {
      return $this->render('general_profil', ['nev' =>$nev]);
    }

    public function actionMyposts($nev)
    {
      return $this->render('myposts', ['nev' =>$nev]);
    }


    public function actionTwatt()
    {
      $model = new AddpostForm();
        if ($model->load(Yii::$app->request->post())) {
          $model->addpost();
          return $this->goHome();
        }
      return $this->render('twatt', ['model'=>$model]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
