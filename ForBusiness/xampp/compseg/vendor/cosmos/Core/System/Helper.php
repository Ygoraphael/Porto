<?php

namespace Cosmos\System;

class Helper {

    public static function redirect(string $url) {
        return header("Location: {$url}");
    }

    public static function encryptPassword(string $password_user): string {
        $password = APP_SALT . $password_user;
        return md5($password);
    }

    public static function createHash(string $email) {
        $time = microtime();
        return hash('whirlpool', $email . $time);
    }

    public static function treatAttributeForGet(string $attribute): string {
        $methodTract = 'get' . ucfirst($attribute);
        return $methodTract;
    }

    public static function createCode() {
        return (int) time();
    }

    public static function validatesMail(string $mail): bool {
        $mail = strtolower($mail);
        $account = '/^[a-zA-Z0-9\._-]+?@';
        $domain = '[a-zA-Z0-9_-]+?\.';
        $gTLD = '[a-zA-Z]{2,6}';
        $ccTLD = '((\.[a-zA-Z]{2,4}){0,1})$/';
        $pattern = $account . $domain . $gTLD . $ccTLD;
        if (preg_match($pattern, $mail)) {
            return true;
        }
        return false;
    }

    public static function my_session_start() {
        return session_start();
    }

    public static function getMonitorQualidadeStatus($percent) {
        if ($percent < 80) {
            $response['icon'] = 'icon-sad2';
            $response['color'] = 'text-danger';
        } else if ($percent < 90) {
            $response['icon'] = 'icon-neutral';
            $response['color'] = 'text-warning';
        } else {
            $response['icon'] = 'icon-smile';
            $response['color'] = 'text-success';
        }
        return (object) $response;
    }

    public static function getStatus($key) {
        switch ($key) {
            case 0:
                $response['alert'] = 'warning';
                $response['status'] = '%%Waiting%%';
                break;
            case 1:
                $response['alert'] = 'success';
                $response['status'] = '%%Active%%';
                break;
            case 2:
                $response['alert'] = 'danger';
                $response['status'] = '%%Suspended%%';
                break;
            case 3:
                $response['alert'] = 'success';
                $response['status'] = '%%Completed%%';
                break;
            case 4:
                $response['alert'] = 'success';
                $response['status'] = '%%Assigned%%';
                break;
            case 100:
                $response['alert'] = 'success';
                $response['status'] = '%%All%%';
                break;
            default:
                $response['alert'] = 'info';
                $response['status'] = '%%Undefined%%';
                break;
        }
        return (object) $response;
    }

    public static function getStatusSurvey($key) {
        switch ($key) {
            case 0:
                $response['alert'] = 'success';
                $response['status'] = '%%Active%%';
                break;
            case 1:
                $response['alert'] = 'success';
                $response['status'] = '%%Completed%%';
                break;
            case 2:
                $response['alert'] = 'danger';
                $response['status'] = '%%Delayed%%';
                break;
            case 3:
                $response['alert'] = 'warning';
                $response['status'] = '%%Opened%%';
                break;
            case 100:
                $response['alert'] = 'success';
                $response['status'] = '%%All%%';
                break;
            default:
                $response['alert'] = 'info';
                $response['status'] = '%%Undefined%%';
                break;
        }
        return (object) $response;
    }

    public static function getStatusNotification($deleted, $value) {

        if ($deleted == 1 && empty($value)) {
            $response['alert'] = 'danger';
            $response['status'] = 'Expired';
        } else if ($deleted == 1 && !empty($value)) {
            $response['alert'] = 'success';
            $response['status'] = 'Completed';
        } else {
            $response['alert'] = 'info';
            $response['status'] = 'Opened';
        }

        return (object) $response;
    }

    public static function getMonthTypeSurvey($type) {
        switch ($type) {
            case 1:
                return "%%Week%%";
                break;
            case 2:
                return "%%Months%%";
                break;
            case 3:
                return "%%Months Pairs%%";
                break;
            case 4:
                return "%%Odd months%%";
                break;
            default:
                return "";
                break;
        }
        return "";
    }

    public static function getNotificationType($type) {
        switch ($type) {
            //survey
            case 1:
                return "icon-checkmark icon-bg-circle bg-cyan";
                break;
            //dialogo
            case 2:
                return "icon-chat_bubble_outline icon-bg-circle bg-teal";
                break;
            //safety walk
            case 3:
                return "icon-android-walk icon-bg-circle bg-amber";
                break;
            //inseguranca
            case 4:
                return "icon-binoculars icon-bg-circle bg-deep-purple";
                break;
            //error
            case 5:
                return "icon-warning icon-bg-circle bg-red";
                break;
            //sistema
            default:
                return "icon-notification icon-bg-circle bg-deep-orange";
                break;
        }
        return "icon-notification icon-bg-circle bg-deep-orange";
    }

    public static function getNotificationUrl($type, $params, $mode = 0) {
        if ($mode == 0) {
            switch ($type) {
                //survey
                case 1:
                    return "/survey/answer/" . implode("/", $params);
                    break;
                //dialogo
                case 2:
                    return "/dialog/answer/" . implode("/", $params);
                    break;
                //safety walk
                case 3:
                    return "/safetywalk/answer/" . implode("/", $params);
                    break;
                //inseguranca
                case 4:
                    return "/Insecurity/answer/" . implode("/", $params);
                    break;
                //error
                case 5:
                    return "";
                    break;
                //sistema
                default:
                    return "";
                    break;
            }
        } else if ($mode == 1) {
            switch ($type) {
                //survey
                case 1:
                    return "/survey/viewanswer/" . implode("/", $params);
                    break;
                //dialogo
                case 2:
                    return "/dialog/viewanswer/" . implode("/", $params);
                    break;
                //safety walk
                case 3:
                    return "/safetywalk/viewanswer/" . implode("/", $params);
                    break;
                //inseguranca
                case 4:
                    return "/Insecurity/viewanswer/" . implode("/", $params);
                    break;
                //error
                case 5:
                    return "";
                    break;
                //sistema
                default:
                    return "";
                    break;
            }
        }
        return "";
    }

    public static function editSurveyHTML($init, $end, $context) {
        self::between($init, $end, $context);
    }

    public static function after($_this, $inthat) {
        if (!is_bool(strpos($inthat, $_this)))
            return substr($inthat, strpos($inthat, $_this) + strlen($_this));
    }

    public static function after_last($_this, $inthat) {
        if (!is_bool(strrevpos($inthat, $_this)))
            return substr($inthat, strrevpos($inthat, $_this) + strlen($_this));
    }

    public static function before($_this, $inthat) {
        return substr($inthat, 0, strpos($inthat, $_this));
    }

    public static function before_last($_this, $inthat) {
        return self::substr($inthat, 0, strrevpos($inthat, $_this));
    }

    public static function between($_this, $that, $inthat) {
        echo self::before($that, self::after($_this, $inthat));
    }

    public static function between_last($_this, $that, $inthat) {
        return self::after_last($_this, self::before_last($that, $inthat));
    }

}