<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index',
                'prefix' => false
            ]
        ]);
    }
    public function beforeRender(Event $event)
    {
        $this->loadModel('Pr');
        $this->loadModel('Po');
        $pr_manual_req = $this->Pr->find('all')
            ->Where(['section'=>'manual','status'=>'requested'])
            ->count();
        $pr_manual_ver = $this->Pr->find('all')
            ->Where(['section'=>'manual','status'=>'verified'])
            ->count();
        $pr_auto1_req = $this->Pr->find('all')
            ->Where(['section'=>'auto-1','status'=>'requested'])
            ->count();
        $pr_auto1_ver = $this->Pr->find('all')
            ->Where(['section'=>'auto-1','status'=>'verified'])
            ->count();
        $pr_auto2_req = $this->Pr->find('all')
            ->Where(['section'=>'auto-2','status'=>'requested'])
            ->count();
        $pr_auto2_ver = $this->Pr->find('all')
            ->Where(['section'=>'auto-2','status'=>'verified'])
            ->count();
        $po_req = $this->Po->find('all')
            ->Where(['status'=>'requested'])
            ->count();
        $po_ver = $this->Po->find('all')
            ->Where(['status'=>'verified'])
            ->count();
        $po_apr1 = $this->Po->find('all')
            ->Where(['status'=>'approved1'])
            ->count();

        $this->loadComponent('Auth');
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->set('role', $this->Auth->user('role'));
        $this->set('user_pic', $this->Auth->user('name'));
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('manual', $pr_manual_req);
        $this->set('auto1', $pr_auto1_req);
        $this->set('auto2', $pr_auto2_req);
        $this->set('manual_v', $pr_manual_ver);
        $this->set('auto1_v', $pr_auto1_ver);
        $this->set('auto2_v', $pr_auto2_ver);
        $this->set('po_req', $po_req);
        $this->set('po_ver', $po_ver);
        $this->set('po_apr1', $po_apr1);
    }
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['logout']);
    }

    public function isAuthorized($user){
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }
}
