<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'        => 'Input',
  'pi_version'     => '1.0.1',
  'pi_author'      => 'Steve Pedersen',
  'pi_author_url'  => 'http://www.bluecoastweb.com/',
  'pi_description' => 'Return value from HTTP Request',
  'pi_usage'       => Input::usage()
);

class Input {
  private $debug = false;

  public function __construct() {
    $this->EE =& get_instance();
    $this->debug = $this->is_truthy($this->EE->TMPL->fetch_param('debug'));
  }

  public function cookie_prefix() {
    // taken from EE_Functions::set_cookie()
    $prefix = (! $this->EE->config->item('cookie_prefix')) ? 'exp_' : $this->EE->config->item('cookie_prefix').'_';
    return $prefix;
  }

  public function cookie() {
    return $this->_value_from('cookie');
  }

  public function env() {
    return $this->_value_from('env');
  }

  public function get() {
    return $this->_value_from('get');
  }

  public function get_post() {
    return $this->_value_from('get_post');
  }

  public function header() {
    return $this->server();
  }

  public function parse() {
    $type = $this->EE->TMPL->fetch_param('type');
    $value = $this->$type();
    $var = $this->EE->TMPL->fetch_param('var');
    if (! $var) {
      $var = $this->EE->TMPL->fetch_param('name');
    }
    return str_replace('{'.$var.'}', $value, $this->EE->TMPL->tagdata);
  }

  public function request() {
    return $this->get_post();
  }

  public function server() {
    return $this->_value_from('server');
  }

  public function uri() {
      return $this->EE->functions->fetch_current_uri();
  }

  // who really cares what the difference is?
  public function url() {
      return $this->uri();
  }

  private function _value_from($type) {
    $name = $this->EE->TMPL->fetch_param('name');
    if ($type == 'env') {
      $value = in_array($name, $_ENV) ? $_ENV[$name] : '';
    } else {
      $value = $this->EE->input->$type($name);
    }
    if ($this->debug) {
      $this->EE->TMPL->log_item(__CLASS__." type=$type name=$name value=$value");
    }
    return $value;
  }

  private function is_truthy($value) {
      $truthy_values = array('on', 'true', 'yes', '1');
      return in_array(strtolower($value), $truthy_values);
  }

  public static function usage() {
    ob_start();
?>
Return the value of an HTTP GET parameter named "page":

  {exp:input:get name="page"}

Return the value of an HTTP GET or POST parameter named "login":

  {exp:input:get_post name="login"}

or:

  {exp:input:request name="login"}

Return the value of HTTP Header named "SERVER_ADDR":

  {exp:input:header name="SERVER_ADDR"}

or:

  {exp:input:server name="SERVER_ADDR"}

Return the value of a cookie named "exp_chocolate_chip":

  {exp:input:cookie name="chocolate_chip"}

Or use any of the above as a tag pair:

  {exp:input:parse type="cookie" name="peanut_butter"}
    The value of the exp_peanut_butter cookie is: {peanut_butter}
  {/exp:input:parse}

  {exp:input:parse type="header" name="HTTP_REFERER" variable="referrer"}
    The value of the HTTP_REFERER (sic) header is: {referrer}
  {/exp:input:parse}

Bonus! Grab the current uri early (rather than ultra late via the {current_url} global var):

  {exp:input:url}

Cookie note:

The "name" parameter of the cookie tag is without the EE cookie prefix (by
default "exp_"). You can ascertain the effective EE cookie prefix by viewing the
output of the following tag:

  {exp:input:cookie_prefix}

<?php
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }
}

/* End of file pi.input.php */
/* Location: /system/expressionengine/third_party/input/pi.input.php */
