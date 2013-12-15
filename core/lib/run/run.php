<?php

define('TOKEN_TAG_OPEN', '[');
define('TOKEN_TAG_CLOSE', ']');
define('TOKEN_ESCAPE_CHAR', '\\');
define('BUFFER_SIZE', 16384);
define('QUOT_CHAR', '"');
define('QUOTID', '%quot_');
define('ASSIGNMENT_CHAR', '=');

global $SYSTEM;
$SYSTEM['token_stack'] = array();

/**
 * Executes a template from file, parsing it line by line replacing
 * any tokens.
 * @param type $file filename of the template to run
 */
function run($file) {
    $fh = @fopen($file, "r");
    if ($fh === false) {
        return;
    }
    ob_start("run_output", BUFFER_SIZE);
    while (!feof($fh)) {
        run_template(fgets($fh));
    }
    ob_end_flush();
    fclose($fh);
}

/**
 * Callback function for ob_start, to finally output the buffer to the screen.
 * @param type $output the buffer
 * @return type string (the screen output)
 */
function run_output($buffer) {
    return $buffer;
}

/**
 * Run a uri and exit.
 * @param string $uri the path of the uri, e.g. css-demo/type
 */
function run_uri($uri) {
    $file = find_uri($uri);
    if ($file !== false) {
        /*
         * Found! Run the template and exit.
         */
        $GLOBALS['SYSTEM']['uri'] = $uri;
        $GLOBALS['SYSTEM']['uri_path'] = dirname($file);
        run($file);
        exit();
    }
    /*
     * Not found.. fallback to core page not found
     */
    run_uri("errors/404");
}

/**
 * Same as run, but runs a string/template
 * @param type $str the string which might contain tokens. The string should not
 * be too large.
 */
function run_template($str) {
    if (empty($str)) {
        return;
    }

    $token_start = strpos($str, TOKEN_TAG_OPEN);

    /*
     * 1. If there are no tokens in this string, it's a very easy case.
     * Just echo the string and done!
     */
    if ($token_start === false) {
        echo $str;
        return;
    }
    $tail = substr($str, $token_start + 1);

    if ($token_start > 0) {
        $head = substr($str, 0, $token_start); //the head part without tokens

        /*
         * 2. Check if the token is escaped, like this: \[token]
         * In that case it is not a real token ("false alarm")
         * and it does not require any special processing. 
         * Just echo token and look for more tokens in the remaining string.
         */


        if ($str{$token_start - 1} == TOKEN_ESCAPE_CHAR) {
            $head{$token_start - 1} = TOKEN_TAG_OPEN;
            echo $head;
            $token_start = strpos($tail, TOKEN_TAG_OPEN);
            if ($token_start !== false) { //there are more tokens...
                run_template($tail, $token_start); //...so let's process them.
            } else {
                echo $tail; //otherwise,just output the tail; 
            }
            return;
        }
        echo $head;
    }


    $sub_levels = 0;
    do {
        $token_end = strpos($tail, ']');

        /*
         * 3.  If the token is not properly closed, e.g. "[token" 
         * it's also not a real token. Just output it and done. 
         */
        if ($token_end === false) {
            echo TOKEN_TAG_OPEN . $tail;
            return;
        }

        /*
         * 3a. Check for sub-tokens and handle these first before continuing
         */

        $sub_token_start = strpos($tail, '[');
        if ($sub_token_start === false || $sub_token_start > $token_end) {
            break;
        }
        $sub_levels++;
        ob_start();
        run_template($tail);
        $tail = ob_get_contents();
        ob_end_clean();
    } while ($sub_token_start !== false && $sub_levels < 10);


    /*
     * 4. At this point the token syntax is valid.
     * Process this token with the run_token function and proceed with the next.
     */
    $token_call = substr($tail, 0, $token_end);
    run_single_token($token_call);

    /*
     * 5. Processing remaining string (tail) 
     */
    $tail = substr($tail, $token_end + 1);
    if ($token_start == 0) { //if a line only contains a token, just return
        $trimmed_tail = rtrim($tail, "\n\r\0");
        if (empty($trimmed_tail)) {
            return;
        }
    } //otherwise, continue processing with a recursive call.
    run_template($tail);
}

/**
 * Helper function to place any quotes back in a string
 * @param type $str
 * @param type $quoted_parts
 */
function _recover_quoted_strings(&$str, &$quoted_parts = null) {
    if (!empty($quoted_parts)) {
        $quot_pos = strpos($str, QUOTID);
        if ($quot_pos !== false) {
            $quot_id = substr($str, $quot_pos);
            $quot = $quoted_parts[$quot_id];
            $str = str_replace($quot_id, $quot, $str);
        }
    }
}

/**
 * Run a token
 * @param type $token_call the token id ("function") and possible parameters
 */
function run_single_token($token_call) {
    /*
     * 1. Normalize the token call. Trim outer spaces, remove double spaces,
     * get parts between "quotes" (which can contain valid spaces).
     */

    global $SYSTEM;
    $call = trim($token_call); //trim outer spaces
    if (strpos($call, QUOT_CHAR) > 0) { //handle quoted parts
        $quoted_parts = array();
        preg_match_all('/' . ASSIGNMENT_CHAR . '[.]*"([^"\\\\]*[\\\\"]*[^"\\\\]*)"/s', $token_call, $dq_matches);
        if (count($dq_matches) > 1) {
            $str_parts = $dq_matches[0];
            $str_vals = $dq_matches[1];
            for ($i = 0; $i < count($str_parts); $i++) {
                $quot_id = QUOTID . count($quoted_parts);
                $search = $str_parts[$i];
                $call = str_replace($search, ASSIGNMENT_CHAR . $quot_id, $call);
                $quoted_parts[$quot_id] = $str_vals[$i];
            }
        }
    }
    $call = preg_replace('!\s+!', ' ', $call); //remove double spaces

    /*
     * 2. Get the token's function id and function parameters
     */
    $call_parts = explode(" ", $call);
    $function_id = $call_parts[0];
    $params = array();
    for ($i = 1; $i < count($call_parts); $i++) { //get parameters (if any)
        $param = $call_parts[$i];
        _recover_quoted_strings($param, $quoted_parts); //recover quoted values
        $assignment_pos = strpos($param, ASSIGNMENT_CHAR);
        if ($assignment_pos > 0) { //handle key-value pairs in syntax as: [token key=value] 
            $param_id = substr($param, 0, $assignment_pos);
            $param_value = substr($param, $assignment_pos + 1);
            $params[$param_id] = $param_value;
        } else { //handle single parameters like "param" in: [token param]
            $params[$param] = $param;
        }
    }

    /*
     * 3. If the token function exists, run it and done.
     */
    $function_name = str_replace("-", "_", $function_id) . "_token";
    if (function_exists($function_name)) {
        run_template($function_name($params));
        return;
    }

    /*
     * 5. Find a template implementing the token, iterating
     * through the environments
     */
    if (count($params) == 0) {
        if (isset($SYSTEM['variables'][$function_id])) {
            run_template($SYSTEM['variables'][$function_id]);
            return;
        }

        $path_tpl = find_template($function_id);
        if ($path_tpl !== false) {
            add_token_level($function_id, $path_tpl);
            run($path_tpl);
            remove_token_level();
            return;
        }
    }

    /*
     * 6. Find a module implementing the token, iterating
     * through the environments
     */
    $path_lib = load_library($function_id);
    if ($path_lib !== false && function_exists($function_name)) {
        add_token_level($function_id, $path_lib);
        run_template($function_name($params));
        remove_token_level();
        return;
    }

    /*
     * 7. If not found as template or as module, just echo the token name
     */
    echo TOKEN_TAG_OPEN . $function_id;
    foreach ($params as $key => $param) {
        if (is_numeric($key)) {
            echo " " . $param;
        } else {
            echo " " . $key . ASSIGNMENT_CHAR . $param;
        }
    }
    echo TOKEN_TAG_CLOSE;
}

function add_token_level($token_name, $path) {
    global $SYSTEM;
    $levels = count($SYSTEM['token_stack']);
    $SYSTEM['token_stack'][$levels] = array($token_name => $path);
}

function remove_token_level() {
    global $SYSTEM;
    $levels = count($SYSTEM['token_stack']) - 1;
    unset($SYSTEM['token_stack'][$levels]);
}

/**
 * Helper function to get the value of a parameter.
 * @param type $params array of parameters
 * @param type $name name of parameter
 * @param type $default_value default value
 * @return type the param value or default value
 */
function get_param_value($params, $name, $default_value = null) {
    if (isset($params[$name])) {
        return $params[$name];
    }
    return $default_value;
}

/**
 * Helper function to get the value of a single parameter like param in [token param]
 * @param type $params list of parameters
 * @param type $name name of parameter
 * @param type $value_exists value to return if it exists
 * @param type $default_value value to retun if it does not exist
 * @return type value_exists or default_value
 */
function get_single_param_value($params, $name, $value_exists, $default_value = null) {
    if (isset($params[$name])) {
        return $value_exists;
    }
    return $default_value;
}

function run_token($params) {

    $tpl = get_param_value($params, "tpl", null);
    if (isset($tpl)) {
        $uri = dirname($tpl);
        $tpl_name = basename($tpl);
    } else {
        $uri = get_param_value($params, "uri", null);
        $tpl_name = "index.tpl";
    }
    if (!empty($uri) && $file = find_uri($uri, $tpl_name)) {
        global $SYSTEM;

        //remember original uri context
        $uri_original = $SYSTEM['uri'];
        $uri_path_original = $SYSTEM['uri_path'];

        //set new uri context
        $SYSTEM['uri'] = $uri;
        $SYSTEM['uri_path'] = dirname($file);

        //prevent infinite loop and run the template
        add_token_level('run', $file);
        run($file);
        remove_token_level('run', $file);

        //restore original uri context
        $SYSTEM['uri'] = $uri_original;
        $SYSTEM['uri_path'] = $uri_path_original;
        return;
    }
}

/**
 * Helper function to run a library token
 * 
 */
function run_library($function_id, $params = null) {
    $function_name = str_replace('-', '_', $function_id) . "_token";
    if (function_exists($function_name)) {
        run_template($function_name($params));
        return;
    }
    $path_lib = load_library($function_id);
    if ($path_lib !== false && function_exists($function_name)) {
        add_token_level($function_id, $path_lib);
        run_template($function_name($params));
        remove_token_level();
    }
}

/**
 * Helper function to return a single token as a string
 * @param type $token the token to run
 */
function run_get_string($token) {
    ob_start();
    run_single_token($token);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

?>
