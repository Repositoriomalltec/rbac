<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
/*     public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    } */
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','about','index','contact','signup','login', 'permission', 'criar-permissao'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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

/*     public function beforeAction($event) {
        if (Yii::$app->Permission->getPermission()){
            return parent::beforeAction($event);
        }else{
            //die('Parou aqui');
            return $this->redirect(['site/permission']);
        }
    } */

    /**
     * {@inheritdoc}
     */
    public function actions() {
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
    public function actionIndex() {
       // \yii\helpers\VarDumper::dump(Yii::$app->Permission->getPermission(), 10, true);
        //die();
/* 
        $auth = Yii::$app->authManager;

        //Definir os papeis (Grupos Admin, supervisor, operador)
        $admin = $auth->createRole('administrador');
        $supervisor = $auth->createRole('supervisor');
        $operador = $auth->createRole('operador');

        //Add os grupos para o authmanager
        $auth->add($admin);
        $auth->add($supervisor);
        $auth->add($operador);
 
        // Mapear rotas
        $viewPost = $auth->createPermission('viewPost');
        $readPost = $auth->createPermission('readPost');
        $updatePost = $auth->createPermission('updatePost');
        $deletePost = $auth->createPermission('deletePost');

        //Add rotas para authmanager
        $auth->add($viewPost);
        $auth->add($readPost);
        $auth->add($updatePost);
        $auth->add($deletePost);

        //Dar permissão para o grupo
        // Grupo ADMIN pode ver tudo.
        $auth->addChild($admin, $viewPost);
        $auth->addChild($admin, $readPost);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);

        //Grupo Supervidor
        $auth->addChild($supervisor, $viewPost);
        $auth->addChild($supervisor, $readPost);
        $auth->addChild($supervisor, $updatePost);

        //Grupo Operador
        $auth->addChild($operador, $viewPost);
        $auth->addChild($operador, $readPost);
        $auth->addChild($operador, $updatePost);

        //Definir qual usuário é de tal grupo
        $auth->assign($admin,1); 
        $auth->assign($supervisor,2); 
        $auth->assign($operador,3);   */

        return $this->render('index');
    }

    public function actionPermission() {
        $usuaId = Yii::$app->user->identity->id;
        $authM = Yii::$app->authManager;
        VarDumper::dump(Yii::$app->user->can('updatePost'), 10, true);
        echo "<p> viewPost {$authM->checkAccess($usuaId, 'viewPost')}</p>";
        echo "<p> readPost {$authM->checkAccess($usuaId, 'readPost')}</p>";
        echo "<p> updatePost {$authM->checkAccess($usuaId, 'updatePost')}</p>";
        echo "<p> deletePost {$authM->checkAccess($usuaId, 'deletePost')}</p>";
        echo "<p> report-aderencia {$authM->checkAccess($usuaId, 'report-aderencia')}</p>";
       // \yii\helpers\VarDumper::dump(Yii::$app->Permission->getPermission(), 10, true);
        //die();
        //die('maria');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
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
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
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
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');

            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
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
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
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

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token) {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
                    'model' => $model
        ]);
    }

}
