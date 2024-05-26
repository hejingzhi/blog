<?php
/**
 * 返回成功后的数据
 *
 * @param mixed $data
 * @param string $msg
 * @return array
 */
function apiSuccessData($data = [], string $msg = '操作成功')
{
    $result = [
        'code' => 1,
        'msg' => $msg
    ];

    $data != [] && $result['data'] = $data;

    return $result;
}

/**
 * 返回失败后的数据
 *
 * @param string $msg
 * @param mixed $data
 * @return array
 */
function apiFailureData(string $msg = '操作失败', $data = [])
{
    $result = [
        'code' => 0,
        'msg' => $msg
    ];

    $data != [] && $result['data'] = $data;

    return $result;
}

/**
 * 密码正则规则
 *
 * @return string
 */
function passwordRegRule()
{
    return '/(?!\d+$)(?![a-zA-Z]+$)[\da-zA-Z]{8,}/';
}

/**
 * 密码验证规则，用于验证rule（必须同时包含字母和数字且不低于8位）
 *
 * @return string
 */
function passwordRegex()
{
    
    return 'regex:' . passwordRegRule();
}
/**
 * 手机号正则规则
 *
 * @return string
 */
function phoneRegRule()
{
    return '/^1[3-9]\d{9}$/';
}

/**
 * 手机号验证规则，用于验证rule（适当放宽号段，避免中间运营商放号）
 *
 * @return string
 */
function phoneRegex()
{
    return 'regex:' . phoneRegRule();
}
/**
 * 检测是否手机号（仅检测Mobile Phone，不能检测Telephone）
 *
 * @param string $phone
 * @return bool
 */
function isPhone(string $phone)
{
    return preg_match(phoneRegRule(), $phone) == 1;
}

/**
 * 检测查询参数
 *
 * @param $idOrCondition
 * @return bool
 */
function checkIdOrCondition($idOrCondition)
{
    return is_int($idOrCondition) or $idOrCondition instanceof Closure;
}
/**
 * 加密数据显示化
 *
 * @param string $str
 * @return string
 */
function encryptVisualData(string $str)
{
    return urlBase64Encode(encryptData($str, config('app.key')));
}
/**
 * 简单数据加密
 *
 * @param string $data
 * @param string $key
 * @return string
 */
function encryptData(string $data, string $key)
{
    $str = '';
    $char = '';
    $key = md5($key);
    $data = base64_encode($data);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }

    return $str;
}
/**
 * 去除Base64编码的特殊符号
 *
 * @param string $str
 * @return string
 */
function urlBase64Encode(string $str)
{
    $data = base64_encode($str);
    $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);

    return $data;
}

/**
 * 还原Base64编码的特殊符号
 *
 * @param string $str
 * @return string
 */
function urlBase64Decode(string $str)
{
    $data = str_replace(['-', '_'], ['+', '/'], $str);
    ($mod = strlen($data)) % 4 && $data .= substr('====', $mod);

    return base64_decode($data);
}
/**
 * 加密手机号
 *
 * @param string $phone
 * @return string
 */
function encryptPhone(string $phone)
{
    $map = ['k', '9', 'c', 'j', '2', '=', 't', 's', '+', '5'];
    $disturb = [0, 2, 3, 5, 6, 7, 8, 10, 11, 12, 14, 15, 16, 17, 18, 20, 22, 23, 24, 27, 28, 30];
    $lastNo = $phone[10];
    $firstNo = $phone[$lastNo];
    $firstStr = $firstNo . substr($phone, 1);
    $secondStr = '';
    for ($i = 0; $i <= 10; $i++) {
        $secondStr .= $map[$firstStr[$i]];
    }
    $thirdStr = encryptVisualData($secondStr);
    $resultChar = md5($thirdStr);
    for ($i = 0; $i < 22; $i++) {
        $resultChar[$disturb[$i]] = $thirdStr[$i];
    }

    return $resultChar;
}

/**
 * 解密手机号
 *
 * @param string $phoneCode
 * @return string
 */
function decryptPhone(string $phoneCode)
{
    try {
        $map = ['k', '9', 'c', 'j', '2', '=', 't', 's', '+', '5'];
        $disturb = [0, 2, 3, 5, 6, 7, 8, 10, 11, 12, 14, 15, 16, 17, 18, 20, 22, 23, 24, 27, 28, 30];
        $phoneChar = '';
        for ($i = 0; $i < 22; $i++) {
            $phoneChar .= $phoneCode[$disturb[$i]];
        }
        $thirdStr = decryptVisualData($phoneChar);
        $secondStr = '';
        for ($i = 0; $i <= 10; $i++) {
            foreach ($map as $key => $val) {
                if ($thirdStr[$i] == $val) {
                    $secondStr .= $key;
                    break;
                }
            }
        }
        $firstStr = '1' . substr($secondStr, 1);

        return $firstStr;
    } catch (Exception $e) {
        return '';
    }
}

/**
 * 手机号部分隐藏
 *
 * @param string $phone
 * @return string
 */
function getHidePhone(string $phone)
{
    return substr_replace($phone, '****', 3, 4);
}


/**
 * 加密数据显示化解密
 *
 * @param string $str
 * @return string
 */
function decryptVisualData(string $str)
{
    return decryptData(urlBase64Decode($str), config('app.key'));
}
/**
 * 简单数据解密
 *
 * @param string $data
 * @param string $key
 * @return string
 */
function decryptData(string $data, string $key)
{
    $char = '';
    $str = '';
    $key = md5($key);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }

    return base64_decode($str);
}