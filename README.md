# reCAPTCHA
Uses the reCAPTCHA system to prevent bots from joining your esoBB forum.

[![License](https://img.shields.io/github/license/aokod/MemberList)]()
[![PHP Version Support](https://img.shields.io/badge/php-%5E8.2-blue)]()

![Photo of the plugin](https://user-images.githubusercontent.com/13023526/236651446-aff0e19e-9db8-40e5-ba9b-6c660c31ffab.png)

### Uploading the plugin to your forum
1. Download this plugin from the [releases page](https://github.com/grntbg/reCAPTCHA/releases/latest) as a plugin package (`reCAPTCHA.zip`).
2. Navigate to your forum's skins page by going to `Dashboard` -> `Plugins`.
3. Under "add a new plugin," you should be able to upload the skin package `reCAPTCHA.zip`.
4. Now that your plugin has been uploaded, you may set it up.  It is now on your forum.

### Setting up the plugin
reCAPTCHA requires an API key to function on your forum.  Obtaining an API key (there are actually two keys) requires for you to sign up for Google Cloud and [register your site](https://www.google.com/recaptcha/admin/create).  You will have to agree to Google's terms of service in order to do this.

1. Register your site on the Google reCAPTCHA Console.
<br/><img src="https://user-images.githubusercontent.com/13023526/236651928-980f26e1-8716-46c7-9c0a-4c378941f582.jpg" alt="Google #1" width="500"/>
<br/><img src="https://user-images.githubusercontent.com/13023526/236651926-201539f4-4eea-4194-b34b-4cd16b483de0.png" alt="Google #2" width="500"/><br/>
2. Navigate to your forum's plugins page by going to `Dashboard` -> `Plugins`.
3. Under the reCAPTCHA plugin, click on the `settings` button.
4. Add the site key and secret key that's given to you by Google, then click `Save changes`.

If you encounter any problems with this plugin, you may join the discussion [on the support forum](https://forum.geteso.org) or [open an issue](https://github.com/aokod/reCAPTCHA/issues).
