<?php

class Response
{

    public $_allow = array();
    public $_content_type = "application/json";
    public $_request = array();
    public $_action = array();

    public $type = array();

    protected $_data = array();


    private $_method = "";
    protected $_code = 200;

    public function __construct()
    {

        //$this->inputs();
    }

    /**
     * @param $data
     * @param $status
     */
    public static function json($data, $status)
    {
        $obj= new Response();
        return  $obj->response($data,$status,'json');

    }
    public function get_referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public function response($data,$status, $exportType = 'json')
    {

        $this->_code = ($status) ? $status : $this->_code;
        $this->set_headers();
        $funcName = 'encode' . ucfirst($exportType);
        echo $this->$funcName($data);
        exit;
        die();
    }

    private function get_status_message()
    {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[$this->_code]) ? $status[$this->_code] : $status[500];
    }

    public function get_request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }




    private function applicationData()
    {
        $contentType = explode(';', $_SERVER['CONTENT_TYPE']); // Check all available Content-Type
        $rawBody = file_get_contents("php://input"); // Read body
        $data = array(); // Initialize default data array

        if(in_array('application/json', $contentType)) { // Check if Content-Type is JSON

            if($this->get_request_method()=="POST")
            {
                $_POST = (array) json_decode($rawBody); // Then decode it
            }

        }

    }


    private function inputs()
    {
        $this->applicationData();
        /*switch ($this->get_request_method()) {
            case "POST":
                $this->_request = $this->cleanInputs($_POST);
                break;
            case "GET":
            case "DELETE":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"), $this->_request);
                $this->_request = $this->cleanInputs($this->_request);
                break;
            default:
                $this->response('', 406);
                break;
        }*/
    }

    public function cleanInputs($data)
    {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    private function set_headers()
    {
        header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
        header("Content-Type:" . $this->_content_type);
    }


    public function encodeHtml($responseData)
    {

        $htmlResponse = "<table border='1'>";
        foreach ($responseData as $key => $value) {
            $htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    public function encodeJson($response)
    {
        $jsonResponse = json_encode($response);
        return $jsonResponse;
    }

    /*public function json($responseData)
    {
        if (is_array($responseData)) {
            return json_encode($responseData);
        }
    }*/


    public function encodeXml($responseData)
    {
        // creating object of SimpleXMLElement
        $xml = new SimpleXMLElement('<?xml version="1.0"?><mobile></mobile>');
        foreach ($responseData as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }

    public function addToData($result = array(), $type = '')
    {

        if ($type != '') {
            $this->_data[$type] = $result;
            $this->type = 'multi';
        } else {

            $this->_data = $result;
            $this->type = 'one';
        }
    }
    public function validateUpdate()
    {

        if ($this->_data['result'] == 1) {
            $response['result'] = $this->_data['result'];
            $this->_code = 200;

        } else {


            $this->_code = 400;
            $response['result'] = '-1';
            $response['status'] = '400';
            $response['message'] = 'Validation Failed';
            if(isset($this->_data['msg']))
            {
                $response['message']=$this->_data['msg'];
            }
            $response['errors'] = $this->_data;
            unset($response['errors']['msg']);
            unset($response['errors']['result']);

        }
        return $response;
    }

    public function validateAdd()
    {

        if ($this->_data['result'] == 1) {
            $this->_code = 201;
            $this->_data['status']= $this->_code;

            return $this->_data;

        } else {

            $this->_code = 400;
            $response['result'] = '-1';
            $response['status'] = '400';
            $response['message'] = 'Validation Failed';
            $response['errors'] = $this->_data;
            unset($response['errors']['msg']);
            unset($response['errors']['result']);
            return $response;


        }
    }

    public function validateToApi()
    {


        if ($this->_data['result'] == 1) {
            $response['result'] = $this->_data['result'];
            if (isset($this->_data['export']['insert_id'])) {
                $response['data'] = $this->_data['export']['insert_id'];
                $this->_code = 201;
            }

        } else {

            $this->_code = 400;
            $response['result'] = '-1';
            $response['status'] = '400';
            $response['status'] = '400';
            $response['message'] = 'Validation Failed';
            $response['errors'] = $this->_data;
            unset($response['errors']['msg']);
            unset($response['errors']['result']);

        }
        return $response;
    }

    public function dataToApi()
    {
        if ($this->type == 'multi') {
            foreach ($this->_data as $type => $data) {
                if ($data['recordsCount'] == 0) {
                    $this->_code = 404;
                    $response[$type]['result'] = -1;
                    $response[$type]['status'] = '404';
                    $response[$type]['message'] = 'Not found!';

                } else {
                    $response[$type] = $this->_data[$type];

                }

            }
            return $response;


        } else {

            //inja shart bayad roye reult bashad na record count
            if (isset($this->_data['recordsCount']) and $this->_data['recordsCount']== '0') {
                $this->_code = 404;
                $response=$this->_data;
                unset($response['meta']);
                $response['result'] = -1;
                $response['status'] = '404';
                $response['message'] = 'Not found!';
                return $response;

            } else {
                $response=$this->_data;
                $response['status'] =$this->_code;
                return $response;
            }
        }

    }

    public function dataToApi1($result)
    {
        if (is_array($result) or is_object($result)) {
            $this->addToData($result);
        }
        $method = $this->get_request_method();
        if ($method == 'POST' or $method == 'PUT' or $method == 'DELETE') {

            $response = $this->validateToApi();


        } else {
            if ($this->type == 'multi') {
                foreach ($this->_data as $type => $data) {
                    if ($data['recordsCount'] == 0) {
                        $this->_code = 404;
                        $response[$type]['result'] = -1;
                        $response[$type]['errors']['status'] = '404';
                        $response[$type]['errors']['message'] = 'Not found!';
                        $response[$type]['errors']['no'] = "1";

                    } else {
                        $response[$type] = $data;

                    }

                }

            } else {
                if ($this->_data['export']['recordsCount'] == 0) {
                    $this->_code = 404;
                    $response['result'] = -1;
                    $response['errors']['status'] = '404';
                    $response['errors']['message'] = 'Not found!';
                    $response['errors']['no'] = "1";

                } else {
                    return $result;
                }

            }

        }


        return $response;
    }


}

?>