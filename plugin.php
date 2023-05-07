<?php
if (!defined("IN_ESO")) exit;

/**
 * reCAPTCHA plugin: uses the Google reCAPTCHA API to provide a captcha
 * that prevents bots from joining the forum.
 */
class reCAPTCHA extends Plugin {
	
var $id = "reCAPTCHA";
var $name = "reCAPTCHA";
var $version = "1.0";
var $description = "Provides verification using Google reCAPTCHA";
var $author = "grntbg";
var $defaultConfig = array(
	"captchaSecret" => NULL,
	"captchaKey" => NULL
);

function init()
{
	parent::init();
	
	// Add language definitions and messages.
	$this->eso->addLanguage("Are you human", "Are you human?");
	$this->eso->addLanguage("Click on the checkbox to verify", "Click on the checkbox to verify");
	$this->eso->addLanguage("Powered by reCAPTCHA", "Powered by reCAPTCHA");
	$this->eso->addMessage("tryAgain", "warning", "Please fill out the captcha.");
	
	// Add the Google script and hook to the join controller so we can add reCAPTCHA to the form.
	if ($this->eso->action == "join") {
		$this->eso->addScript("https://www.google.com/recaptcha/api.js", -1);
		$this->eso->controller->addHook("init", array($this, "initCaptchaForm"));
	}
}//init

// Add the captcha fieldset and input to the join form.
function initCaptchaForm(&$join)
{
	global $config, $language;

	$join->addFieldset("verifyRecaptcha", $language["Are you human"], 900);
	$join->addToForm("verifyRecaptcha", array(
		"id" => "recaptcha",
		"html" => "<label style='margin-bottom:5px'>{$language["Click on the checkbox"]}<br/><small>{$language["Powered by reCAPTCHA"]}</small></label> <div class='g-recaptcha' data-sitekey='{$config["reCAPTCHA"]["captchaKey"]}'></div>",
		"validate" => array($this, "validateCaptcha"),
		"required" => true
	));
}//initCaptchaForm

// Validate the captcha input.
function validateCaptcha($input)
{
	global $config;
	$token = $config["reCAPTCHA"]["captchaSecret"];

	if (!$POST["g-recaptcha-response"]) return "tryAgain";

	if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])) {
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($token).'&response='.urlencode($_POST["g-recaptcha-response"]));
		$responseKeys = json_decode($verifyResponse, true);
		if (!$responseKeys["success"]) return "tryAgain";
	} else {
		return "tryAgain";
	}
}//validateCaptcha

// Plugin settings: captcha preview and how many characters to use.
function settings()
{
	global $config, $language;

	// Add language definitions.
	$this->eso->addMessage("captchaEmpty", "warning", "Please enter a valid reCAPTCHA key.");
	$this->eso->addLanguage("captchaKey", "reCAPTCHA site key");
	$this->eso->addLanguage("captchaSecret", "reCAPTCHA secret key");

	// Generate settings panel HTML.
	$settingsHTML = "<ul class='form'>
	<li><label>{$language["captchaKey"]}</label> <input name='reCAPTCHA[captchaKey]' type='text' class='text' value='{$config["reCAPTCHA"]["captchaKey"]}'/></li>
	<li><label>{$language["captchaSecret"]}</label> <input name='reCAPTCHA[captchaSecret]' type='text' class='text' value='{$config["reCAPTCHA"]["captchaSecret"]}'/></li>
	<li><label></label> " . $this->eso->skin->button(array("value" => $language["Save changes"], "name" => "saveSettings")) . "</li>
	</ul>";
	
	return $settingsHTML;
}//setings

// Save the plugin settings.
function saveSettings()
{
	global $config;
	if (is_empty(!$config["reCAPTCHA"]["captchaKey"]) or is_empty($config["reCAPTCHA"]["captchaSecret"])) $this->eso->message("captchaEmpty");
	$config["reCAPTCHA"]["captchaKey"] = $_POST["reCAPTCHA"]["captchaKey"];
	$config["reCAPTCHA"]["captchaSecret"] = $_POST["reCAPTCHA"]["captchaSecret"];
	writeConfigFile("config/reCAPTCHA.php", '$config["reCAPTCHA"]', $config["reCAPTCHA"]);
	$this->eso->message("changesSaved");
}//saveSettings

}//reCAPTCHA

?>
