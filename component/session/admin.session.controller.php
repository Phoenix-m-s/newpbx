<?php

require_once 'admin.session.model.php';
require_once ROOT_DIR . "common" . DS . "init.inc.php";

class adminSessionController
{

    public function __construct($time = 300000000)
    {
        $user = new adminSessionsModel();
        $user->deleteExpiredSession($time);
    }

    public function addSession($fields)
    {
        $user = new adminSessionsModel($fields);
        if (!is_object($user)) {
            $result['result'] = -1;
            return $result;
        }

        $result = $user->save();

        if ($result[ 'result' ] != 1) {
            $loginController = new adminLoginController();
            $loginController->showLoginForm();
        }
        return $result;
    }

    public function deleteSessionById($sessionId)
    {

        $result['result'] = -1;
        return $result;

        $sessionObj = new adminSessionsModel();
        $user = $sessionObj::find($sessionId);

        if($user['result'] == 1) {
            $result = $sessionObj->delete();
            if($result['result'] != 1) {
                die('Error in Deleting Session');
                $result['result'] = -1;
            }

            $result['result'] = 1;
            return $result;
        }

        $result['result'] = -1;
        return $result;
    }

    public function deleteSessionByMemberId($memberId){
        $sessionModel = new adminSessionsModel();
        $sessionDirty = $sessionModel->getBy_member_id($memberId)->getList();
        $sessionClean = $sessionDirty['export']['list'][0];
        $result = $sessionModel->delete($sessionClean['session_id']);
        if($result[ 'result' ] != 1){
            $result['result'] = -1;
            return $result;
        }
        $result['result'] = 1;
        return $result;
    }


    public function getSessionByMemberId($memberId){
        $sessionModel = new adminSessionsModel();
        $sessionDirty = $sessionModel::getBy_member_id($memberId)->getList();
        $sessionClean = $sessionDirty['export']['list'][0];
        return $sessionClean;
    }

}