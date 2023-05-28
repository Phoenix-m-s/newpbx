<?php

include_once ( ROOT_DIR . "component/Validators.class.php" );

/**
 * @author Malekloo Izadi Sakhamanesh <Izadi@dabacenter.ir>
 * @version 0.0.1 this is the beta version of News
 * @copyright 2015 The Imen Daba Parsian Co.
 */
class extension_operation
{
    /**
     * Contains extension info
     * @var
     */
    private $_extensionInfo;

    /**
     * Contains List of extensions
     * @var
     */
    private $_extensionList;

    /**
     * Contains the information of a voice mail
     * @var
     */
    private $_voiceMailInfo;

    /**
     * Contains the list of all the voice mails
     * @var
     */
    private $_voiceMailList;

    /**
     * @var
     */
    public $_set;

    /**
     * Accessing the database
     * @var
     */
    private $_extensionDbObj;

    /**
     * @var
     */
    private $_IDs;

    /**
     * Contains extension info
     * @var
     */
    private $_paging;

    /**
     * @var
     */
    public $addForm;

    /**
     * @var
     */
    public $editForm;

    /**
     * Specifies the type of output
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __construct ()
    {
        $this->_extensionInfo = array();
        $this->addForm = array();
        $this->addForm = array(
            'Extension_Name' => '',
            'Extension_No' => '',
            'caller_id_number' => '',
            'ring_number' => '',
            'Secret' => '',
            'Secret2' => '',
            'Internal_Recording' => '',
            'External_Recording' => '',
            'Voicemail_Status' => '',
            'Voicemail_Email' => '',
            'Voicemail_Pass' => '',
            'User_Name' => '',
            'Password' => '',
            'successDialDestination' => '',
            'successForward' => '',
            'successDSTOption' => '',
            'failedDialDestination' => '',
            'failedForward' => '',
            'failedDSTOption' => ''
        );
        $this->editForm = array();
        $this->editForm = array(
            'id' => '',
            'Extension_Name' => '',
            'Extension_No' => '',
            'caller_id_number' => '',
            'ring_number' => '',
            'Secret' => '',
            'Secret2' => '',
            'Internal_Recording' => '',
            'External_Recording' => '',
            'Voicemail_Status' => '',
            'Voicemail_Email' => '',
            'Voicemail_Pass' => '',
            'User_Name' => '',
            'Password' => '',
            'successDialDestination' => '',
            'successForward' => '',
            'successDSTOption' => '',
            'failedDialDestination' => '',
            'failedForward' => '',
            'failedDSTOption' => ''
        );
    }

    /**
     * Specifies the type of output
     * @param $property
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     */
    public function __set ( $property, $value )
    {

        switch ($property) {

            default:
                break;
        }

    }

    /**
     * Specifies the type of output
     * @param $method
     * @param $args
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    function __call ( $method, $args )
    {
        $method = '_' . $method;

        if ( method_exists ( $this, $method ) ) {
            switch ($method) :
                case "_set_info" :
                    return $this->_set_info ( $args[ '0' ] );
                    break;
                case "_set_extensionInfo" :
                    return $this->_set_extensionInfo ( $args[ '0' ] );
                    break;
                case "_set_IDs" :
                    return $this->_set_IDs ( $args[ '0' ] );
                    break;
                case "_changeStatus" :
                    return $this->_changeStatus ( $args[ '0' ] );
                    break;
                case "_check" :
                    return $this->$method( $args );
                    break;
                case "_getPointAction" :
                    return $this->$method( $args[ 0 ] );
                    break;
                case "_deleteExtension" :
                    return $this->_deleteExtension ( $args[ '0' ] );
                    break;
                case "_trashExtension" :
                    return $this->_trashExtension ( $args[ '0' ] );
                    break;
                case "_recycleExtension" :
                    return $this->_recycleExtension ( $args[ '0' ] );
                    break;
                case "_getExtensionList" :
                    return $this->_getExtensionList ( $args[ '0' ] );
                    break;
                case "_getExtensionListById" :
                    return $this->_getExtensionListById ( $args[ '0' ] );
                    break;
                case "_insertExtension" :
                    return $this->_insertExtension ();
                    break;
                case "_updateExtension" :
                    return $this->_updateExtension ();
                    break;
                case "_getExtensionByCompany" :
                    return $this->_getExtensionByCompany ( $args[ '0' ] );
                    break;
                case "_checkAnnounceDependency" :
                    return $this->_checkAnnounceDependency ( $args[ '0' ] );
                    break;
                case "_checkQueueDependency" :
                    return $this->_checkQueueDependency ( $args[ '0' ] );
                    break;
                case "_checkInboundDependency" :
                    return $this->_checkInboundDependency ( $args[ '0' ] );
                    break;
                case "_checkIvrDependency" :
                    return $this->_checkIvrDependency ( $args[ '0' ] );
                    break;
                case "_getVoiceMailList" :
                    return $this->_getVoiceMailList ( $args[ '0' ] );
                    break;
                case "_checkIfNameExists" :
                    return $this->_checkIfNameExists ( $args[ '0' ], $args[ '1' ] );
                    break;

            endswitch;
        }

    }

    /**
     * Validation for fields
     * @param  $value
     * @return  mixed
     * @author  Malekloo,Izadi,Sakhamanesh
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     *
     */
    private function _set_info ( $value = '' )
    {
        $result[ 'result' ] = 1;
        return $result;
    }

    /**
     * Specifies the value of each field.
     * Setter can act in 2 ways.
     * 1)It gets all the input at once
     * 2)It gets the fields one by one
     * We have used the 2nd method.
     * @param $value
     * @return  mixed
     * @author  Malekloo,Izadi,Sakhamanesh
     * @version 01.01.01
     * @since 01.01.01
     * @date    08/08/2015
     *
     */
    private function _set_extensionInfo ( $value = '' )
    {

        global $admin_info, $company_info;
        $result[ 'result' ] = 1;

        /**
         * Checks if the value of announce_id is not empty and is integer.
         */
        if ( isset( $value[ 'comp_id' ] ) ) {

            if ( empty( $value[ 'comp_id' ] ) ) {
                $msg = ModelANNOUNCE_09;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'comp_id' ] = $msg;
            } elseif ( !Validator::Numeric ( $value[ 'comp_id' ] ) ) {
                $msg = ModelANNOUNCE_10;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'id' ] = $msg;
            } else {
                $this->_extensionInfo[ 'comp_id' ] = $value[ 'comp_id' ];
            }

        } else {
            $this->_extensionInfo[ 'comp_id' ] = $company_info[ 'comp_id' ];
        }


        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if ( isset( $value[ 'id' ] ) ) {

            if ( empty( $value[ 'id' ] ) ) {
                $msg = ModelEXTENSION_01;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'id' ] = $msg;
            } elseif ( !Validator::Numeric ( $value[ 'id' ] ) ) {
                $msg = ModelANNOUNCE_10;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'id' ] = $msg;
            } else {
                $this->_extensionInfo[ 'id' ] = $value[ 'id' ];
            }

        }

        /**
         * Checks if the value of ID is not empty and is integer.
         */
        if ( isset( $value[ 'Extension_ID' ] ) ) {
            if ( empty( $value[ 'Extension_ID' ] ) ) {
                $msg = ModelEXTENSION_01;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_ID' ] = $msg;
            } elseif ( !Validator::Numeric ( $value[ 'Extension_ID' ] ) ) {
                $msg = ModelCOMPANY_04;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_ID' ] = $msg;
            } else {
                $this->_extensionInfo[ 'Extension_ID' ] = $value[ 'Extension_ID' ];
            }

        }

        if ( isset( $value[ 'caller_id_number' ] ) ) {
            $this->_extensionInfo[ 'caller_id_number' ] = $value[ 'caller_id_number' ];
        }


        if ( isset( $value[ 'ring_number' ] ) ) {
            $this->_extensionInfo[ 'ring_number' ] = $value[ 'ring_number' ];
        }

        /**
         * Checks if the value of Company name is not empty and is string.
         */
        if ( isset( $value[ 'Extension_Name' ] ) ) {
            if ( empty( $value[ 'Extension_Name' ] ) ) {
                $msg = ModelEXTENSION_02;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_Name' ] = $msg;
            } elseif ( !is_string ( $value[ 'Extension_Name' ] ) ) {
                $msg = ModelEXTENSION_03;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_Name' ] = $msg;
            } else {
                $this->_extensionInfo[ 'Extension_Name' ] = $value[ 'Extension_Name' ];
            }

        }

        /**
         * Checks if the value of manager name is not empty and is string.
         */
        if ( isset( $value[ 'Extension_No' ] ) ) {
            if ( empty( $value[ 'Extension_No' ] ) ) {
                $msg = ModelEXTENSION_04;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_No' ] = $msg;
            } elseif ( !Validator::Numeric ( $value[ 'Extension_No' ] ) ) {
                $msg = ModelEXTENSION_05;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Extension_No' ] = $msg;
            } else {
                $this->_extensionInfo[ 'Extension_No' ] = $value[ 'Extension_No' ];
            }

        }

        /**
         * Checks if the value of address is not empty and is integer.
         */
        if ( isset( $value[ 'Secret' ] ) ) {
            if ( empty( $value[ 'Secret' ] ) ) {
                $msg = ModelEXTENSION_06;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Secret' ] = $msg;
            } else {
                $this->_extensionInfo[ 'Secret' ] = $value[ 'Secret' ];
            }

        }

        if ( isset( $value[ 'User_Name' ] ) ) {
            if ( empty( $value[ 'User_Name' ] ) ) {
                $msg = ModelEXTENSION_16;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'User_Name' ] = $msg;
            } else {
                $this->_extensionInfo[ 'User_Name' ] = $value[ 'User_Name' ];
            }
        }

        if ( isset( $value[ 'Password' ] ) ) {
            if ( empty( $value[ 'Password' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'Password' ] = $msg;
            } else {
                $this->_extensionInfo[ 'Password' ] = $value[ 'Password' ];
            }
        }

        if ( isset( $value[ 'successDialDestination' ] ) ) {
            if ( empty( $value[ 'successDialDestination' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'successDialDestination' ] = $msg;
            } else {
                $this->_extensionInfo[ 'successDialDestination' ] = $value[ 'successDialDestination' ];
            }
        }

        if ( isset( $value[ 'successForward' ] ) ) {
            if ( empty( $value[ 'successForward' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;
                $result[ 'msgList' ][ 'successForward' ] = $msg;
            } else {
                $this->_extensionInfo[ 'successForward' ] = $value[ 'successForward' ];
            }
        }

        if ( isset( $value[ 'successDSTOption' ] ) ) {
            if ( empty( $value[ 'successDSTOption' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'successDSTOption' ] = $msg;
            } else {
                $this->_extensionInfo[ 'successDSTOption' ] = $value[ 'successDSTOption' ];
            }
        }

        if ( isset( $value[ 'failedDialDestination' ] ) ) {
            if ( empty( $value[ 'failedDialDestination' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'failedDialDestination' ] = $msg;
            } else {
                $this->_extensionInfo[ 'failedDialDestination' ] = $value[ 'failedDialDestination' ];
            }
        }

        if ( isset( $value[ 'failedForward' ] ) ) {
            if ( empty( $value[ 'failedForward' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'failedForward' ] = $msg;
            } else {
                $this->_extensionInfo[ 'failedForward' ] = $value[ 'failedForward' ];
            }
        }

        if ( isset( $value[ 'failedDSTOption' ] ) ) {
            if ( empty( $value[ 'failedDSTOption' ] ) ) {
                $msg = ModelEXTENSION_17;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'failedDSTOption' ] = $msg;
            } else {
                $this->_extensionInfo[ 'failedDSTOption' ] = $value[ 'failedDSTOption' ];
            }
        }

        /**
         * Checks if the value of email is not empty and is integer.
         */

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'Voicemail_Status' ] ) ) {
            if ( $value[ 'Voicemail_Status' ] == 'on' or $value[ 'Voicemail_Status' ] == 1) {
                $this->_extensionInfo[ 'Voicemail_Status' ] = 1;
            } else {
                $this->_extensionInfo[ 'Voicemail_Status' ] = 0;
            }

        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'Internal_Recording' ] ) ) {
            if ( $value[ 'Internal_Recording' ] == 'on' or $value[ 'Internal_Recording' ] == 1 ) {
                $this->_extensionInfo[ 'Internal_Recording' ] = 1;
            } else {
                $this->_extensionInfo[ 'Internal_Recording' ] = 0;
            }

        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'External_Recording' ] ) ) {
            if ( $value[ 'External_Recording' ] == 'on' or $value[ 'External_Recording' ] == 1 ) {
                $this->_extensionInfo[ 'External_Recording' ] = 1;
            } else {
                $this->_extensionInfo[ 'External_Recording' ] = 0;
            }

        }
        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'Internal_Recording' ] ) ) {
            if ( $value[ 'Internal_Recording' ] == '0' ) {
                $this->_extensionInfo[ 'Internal_Recording' ] = 0;
            } else {
                $this->_extensionInfo[ 'Internal_Recording' ] = 1;
            }

        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'External_Recording' ] ) ) {
            if ( $value[ 'External_Recording' ] == '0' ) {
                $this->_extensionInfo[ 'External_Recording' ] = 0;
            } else {
                $this->_extensionInfo[ 'External_Recording' ] = 1;
            }

        }

        /**
         * Checks if the value of email is not empty and is integer.
         */
        if ( isset( $value[ 'Voicemail_Email' ] ) ) {
            if ( empty( $value[ 'Voicemail_Email' ] ) ) {
                $msg = 'Please enter voice mail email.';

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;

                $result[ 'msgList' ][ 'email' ] = $msg;
            } /*elseif(!Validator::Email($value['Voicemail_Email']))
            {
                $msg='Email format is not valid.';

                if($result['result']==1)
                {
                    $result['msg'] = $msg;
                }
                $result['result'] = -1;
                $result['err'] = -2;

                $result['msgList']['Voicemail_Email'] =  $msg;
            }*/

            else {
                $this->_extensionInfo[ 'Voicemail_Email' ] = $value[ 'Voicemail_Email' ];
            }

        }

        /**
         * Checks if the value of phone number is not empty and is numeric.
         */
        if ( isset( $value[ 'Voicemail_Pass' ] ) ) {
            if ( empty( $value[ 'Voicemail_Pass' ] ) ) {
                $msg = ModelEXTENSION_07;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;
                $result[ 'msgList' ][ 'Voicemail_Pass' ] = $msg;
            } elseif ( !is_string ( $value[ 'Voicemail_Pass' ] ) ) {
                $msg = ModelEXTENSION_08;

                if ( $result[ 'result' ] == 1 ) {
                    $result[ 'msg' ] = $msg;
                }
                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;
                $result[ 'msgList' ][ 'Voicemail_Pass' ] = $msg;

            } else {
                $this->_extensionInfo[ 'Voicemail_Pass' ] = $value[ 'Voicemail_Pass' ];
            }

            /**
             * Checks if the value of ID is not empty and is integer.
             */
            if ( isset( $value[ 'Secret' ] ) || isset( $value[ 'Secret2' ] ) ) {
                if ( $value[ 'Secret' ] != $value[ 'Secret2' ] ) {
                    $msg = ModelEXTENSION_09;

                    if ( $result[ 'result' ] == 1 ) {
                        $result[ 'msg' ] = $msg;
                    }
                    $result[ 'result' ] = - 1;
                    $result[ 'err' ] = - 2;

                    $result[ 'msgList' ][ 'id' ] = $msg;
                }
            }

            /**
             * Checks if the value of ID is not empty and is integer.
             */
            if ( isset( $value[ 'Voicemail_Email' ] ) || isset( $value[ 'Voicemail_Pass' ] ) ) {
                if ( ( $value[ 'Voicemail_Status' ] ) === NULL ) {
                    $msg = ModelEXTENSION_10;

                    if ( $result[ 'result' ] == 1 ) {
                        $result[ 'msg' ] = $msg;
                    }
                    $result[ 'result' ] = - 1;
                    $result[ 'err' ] = - 2;

                    $result[ 'msgList' ][ 'id' ] = $msg;
                }

            }

        }

        return $result;
    }

    /**
     * Specifies the type of output
     * @param $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _set_IDs ( $value = '' )
    {
        $result[ 'result' ] = 1;

        foreach ($value as $key => $val) {

            if ( is_numeric ( $val ) && !empty( $val ) ) {
                $this->_IDs[ $key ] = $val;
            } else {
                $msg = $val . ModelANNOUNCE_08;

                if ( $result[ 'result' ] == 1 ) {
                    $res[ 'msg' ] = $msg;
                }

                $result[ 'result' ] = - 1;
                $result[ 'err' ] = - 2;
                $result[ 'msgList' ][ $key ] = $msg;
            }
        }

        return $result;
    }

    /**
     * Specifies the value of each field
     * @param $field
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    public function __get ( $field )
    {
        switch ($field) {
            case 'extensionList':
                return $this->_extensionList;
                break;
            case 'voiceMailInfo':
                return $this->_voiceMailInfo;
                break;
            case 'voiceMailList':
                return $this->_voiceMailList;
                break;
            case 'extensionInfo':
                return $this->_extensionInfo;
                break;
            case 'paging':
                return $this->_paging;
                break;
            default:
                break;
        }
    }

    /**
     * Gets the extension list based on its ID
     * @param $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getExtensionListById ( $Extension_ID )
    {
        global $conn, $lang;

        if ( is_int ( $Extension_ID ) ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 1;
            $result[ 'msg' ] = ModelCOMPANY_16;
            $result[ 'func' ] = 'getCompanyListById';
            return $result;
        }

        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->getExtensionById ( $Extension_ID );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $this->_set_ExtensionInfo ( $this->_extensionDbObj->extensionFields );
        $this->_extensionInfo = $this->_extensionDbObj->extensionFields;
        unset( $this->_companyDbObj );
        $result[ 'result' ] = 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Access the database class
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function getExtensionDbObj ()
    {
        include_once ( ROOT_DIR . "component/extension.db.class.php" );
        $this->_extensionDbObj = new extension_db();
    }

    /**
     * Deletes extension
     * @param  $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteExtension_temp ( $Extension_ID )
    {
        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->removeExtensionDB ( $Extension_ID );

        if ( $result == - 1 ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 2;
            return $result;
        }

        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        return $result;
    }

    /**
     * delete extension
     * @param  $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _deleteExtension ( $Extension_ID )
    {
        global $admin_info, $company_info;

        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->removeExtensionDB ( $Extension_ID );

        if ( $result == - 1 ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 2;
            return $result;
        }

        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        //***********************************

        include_once ( ROOT_DIR . "component/package.db.class.php" );

       /* $packageLogResult = package_db::calculateExtension ( '-', $company_info[ 'comp_id' ] );


        if ( $packageLogResult == - 1 ) {
            $packageLogResult[ 'result' ] = - 1;
            $packageLogResult[ 'no' ] = 2;
            return $packageLogResult;
        }*/

        include_once ( ROOT_DIR . "component/company.db.class.php" );
        $companyResult = company_db::updateReload ();

        if ( $companyResult == - 1 ) {
            $companyResult[ 'result' ] = - 1;
            $companyResult[ 'no' ] = 2;
            return $companyResult;
        }

        return $result;
    }

    /**
     * Recycle extension
     * @param  $Extension_ID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @since   08/08/2015
     * @date    08/08/2015
     */
    private function _recycleExtension ( $Extension_ID )
    {
        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->recycleExtensionDB ( $Extension_ID );

        if ( $result == - 1 ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 2;
            return $result;
        }

        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        return $result;
    }

    /**
     * Gets the extension list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getExtensionList ( $fields )
    {
        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->getExtension ( $fields );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $this->_paging = $this->_extensionDbObj->paging;
        $this->_extensionList = $this->_extensionDbObj->extensionListDb;
        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    private function _getAllExtension ( $fields )
    {
        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->getExtension ( $fields );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $this->_paging = $this->_extensionDbObj->paging;
        $this->_extensionList = $this->_extensionDbObj->extensionListDb;
        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Gets the voice mail list
     * @param  $fields
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getVoiceMailList ( $fields )
    {

        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->getVoiceMailList ( $fields );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $this->_paging = $this->_extensionDbObj->paging;
        $this->_extensionList = $this->_extensionDbObj->extensionListDb;
        unset( $this->_extensionDbObj );
        $result[ 'result' ] = 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Insert extension
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _insertExtension ()
    {
        global $conn, $lang;
        global $admin_info, $company_info;
        $this->getExtensionDbObj();
        $result = $this->_extensionDbObj->set_extensionFields($this->_extensionInfo);

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $resultInsert = $this->_extensionDbObj->insertExtensionDB ();

        if ( $resultInsert[ 'result' ] == - 1 ) {
            return $resultInsert[ 'msg' ];
        }

        $result = $this->set_extensionInfo ( $this->_extensionDbObj->extensionFields );
        $result[ 'result' ] = 1;
        $result[ 'no' ] = 2;

        include_once ( ROOT_DIR . "component/package.db.class.php" );

       /* $packageLogResult = package_db::calculateExtension ( '+', $company_info[ 'comp_id' ] );


        if ( $packageLogResult == - 1 ) {
            $packageLogResult[ 'result' ] = - 1;
            $packageLogResult[ 'no' ] = 2;
            return $packageLogResult;
        }*/

        include_once ( ROOT_DIR . "component/company.db.class.php" );
        $companyResult = company_db::updateReload ();

        if ( $companyResult == - 1 ) {
            $companyResult[ 'result' ] = - 1;
            $companyResult[ 'no' ] = 2;
            return $companyResult;
        }
        return $result;
    }

    /**
     * Update the extension
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _updateExtension ()
    {
        //global $conn, $lang;
        $this->getExtensionDbObj();
        $result = $this->_extensionDbObj->set_extensionFields ( $this->_extensionInfo );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $resultUpdate = $this->_extensionDbObj->updateExtensionDB ();
        if ( $resultUpdate[ 'result' ] == - 1 ) {
            return $resultUpdate[ 'msg' ];
        }

        include_once ( ROOT_DIR . "component/company.db.class.php" );
        $companyResult = company_db::updateReload ();

        if ( $companyResult == - 1 ) {
            $companyResult[ 'result' ] = - 1;
            $companyResult[ 'no' ] = 2;
            return $companyResult;
        }

        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Changes the status of extension
     * @param  $value
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _changeStatus ( $value = '' )
    {

        if ( $value == 'Disable' ) {
            $value = '0';
        } else if ( $value == 'Enable' ) {
            $value = '1';
        }

        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->set_IDs ( $this->_IDs );

        if ( $result[ 'result' ] == - 1 ) {
            return $result;
        }

        $result = $this->_extensionDbObj->changeStatusDB ( $value );

        if ( !isset( $result[ 'result' ] ) or $result[ 'result' ] == - 1 ) {
            return $result;
        }

        return $result;
    }

    /**
     * Gets the Extension list based on company
     * @param   $companyID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _getExtensionByCompany ( $companyID )
    {
        //global $conn, $lang;
        if ( is_int ( $companyID ) ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 1;
            $result[ 'msg' ] = ModelCOMPANY_16;
            $result[ 'func' ] = 'getAnnounceListById';
            return $result;
        }

        $this->getExtensionDbObj ();
        $where = "comp_id= '$companyID'";
        $result = $this->_extensionDbObj->GetAll ( $where );
        $this->_extensionList = $this->_extensionDbObj->extensionListDb;
        unset( $this->_queueDbObj );
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $extensionID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkAnnounceDependency ( $extensionID )
    {
        //global $conn, $lang;
        include_once ( ROOT_DIR . "component/announce.operation.class.php" );
        $announce = new announce_operation();
        $result = $announce->getAnnounceByExtension ( $extensionID );

        if ( $result[ 'result' ] = 1 ) {
            $result[ 'list' ] = $announce->announceList;
            return $result;
        }
        $result[ 'msg' ] = 'error _checkAnnounceDependency';
        $result[ 'result' ] = - 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $extensionID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkQueueDependency ( $extensionID )
    {
        //global $conn, $lang;
        include_once ( ROOT_DIR . "component/queue.operation.class.php" );
        $queue = new queue_operation();
        $result = $queue->getQueueByExtension ( $extensionID );

        if ( $result[ 'result' ] = 1 ) {
            $result[ 'list' ] = $queue->queueList;
            return $result;
        }

        $result[ 'result' ] = - 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $extensionID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkInboundDependency ( $extensionID )
    {
        //global $conn, $lang;
        include_once ( ROOT_DIR . "component/inbound.operation.class.php" );
        $inbound = new inbound_operation();
        $result = $inbound->getInboundByExtension ( $extensionID );


        if ( $result[ 'result' ] = 1 ) {
            $result[ 'list' ] = $inbound->inboundList;
            return $result;
        }
        $result[ 'msg' ] = 'error inbound';
        $result[ 'result' ] = - 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Checks the dependency before deleting
     * @return  mixed
     * @param  $extensionID
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIvrDependency ( $extensionID )
    {
        //global $conn, $lang;
        include_once ( ROOT_DIR . "component/ivr.operation.class.php" );
        $inbound = new ivr_operation();
        $result = $inbound->getIvrByExtension ( $extensionID );

        if ( $result[ 'result' ] = 1 ) {
            $result[ 'list' ] = $inbound->ivrList;
            return $result;
        }
        $result[ 'msg' ] = 'error checkIvrDependency';
        $result[ 'result' ] = - 1;
        $result[ 'no' ] = 2;
        return $result;
    }

    /**
     * Gets the Sip list based on its ID
     * @param   $name
     * @param   $compID
     * @return  mixed
     * @author  Malekloo, Sakhamanesh, Izadi
     * @version 01.01.01
     * @date    08/08/2015
     */
    private function _checkIfNameExists ( $name, $compID )
    {
        //global $conn, $lang;
        $this->getExtensionDbObj ();
        $result = $this->_extensionDbObj->checkIfNameExistsDB ( $name, $compID );

        if ( $result == - 1 ) {
            $result[ 'result' ] = - 1;
            $result[ 'no' ] = 2;
            return $result;
        }

        $result[ 'result' ] = 1;
        return $result;
    }

}

