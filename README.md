# Wygwam Enhanced Image

Wygwam Enhanced Image is an extension for the ExpressionEngine Platform and Wygwam's CKEditor. It replaces the default Image plugin with the [Enhanced Image](http://ckeditor.com/addon/image2) plugin.

![Wygwam Enhanced Image Example](https://monosnap.com/file/HgE5NMMFM3DFhYrrrTDadpvECDYxDq.png)

## Requirements

[Wygwam 3.3.3](https://devot-ee.com/add-ons/wygwam)

[CKEditor](http://ckeditor.com/) 4.4.+ *(4.4.6 is included with Wygwam 3.3.3 so you're good there.)*

[ExpressionEngine](https://ellislab.com/expressionengine) 2.7 or later

*Tested working in EE 2.7.2 - Please let me know if it's not working in other versions by creating an [issue](https://github.com/Natetronn/wygwam-enhanced-image/issues) and I'll address it asap.*

Note: I've included files for Enhanced Image plugin version 4.3.5 and a second copy of 4.4.7 in the theme folder for your convenience. Switching down to 4.3.5 *may*  allow you to get back to Wygwam 3.3, 3.3.1 or 3.3.2 and their earlier version of CKEditor 4.3. Note the [Wygwam changelog](http://docs.pixelandtonic.com/wygwam/changelog.html) for reference.

## Important Note!
Currently [Enhanced Image](http://ckeditor.com/addon/image2) plugin has what appears to be a bug which, when switched to Class based CSS in the extension settings, doesn't allow the Captioned Class to work as expected. I've submitted a [comment](http://ckeditor.com/comment/reply/132795/136435) on Enhanced Image including details of the issue and am currently waiting a response. I'll update the repo with an updated Enhanced Image plugin if and when it gets addressed. In the meantime it appears that the default Captioned Class of "image" is applied no matter if inline or css based is set.

If you want custom class based captions to work (probably a good way to go) you can comment out line 1537 of `themes/third_party/wygwam_enhanced_img/image2/plugin.js`. Make sure you clear cache for this to take effect. Also note, switching back to inline will produce a figure with a class which looks like the following `<figure class="{captionedClass}">` and therefore you'll need to uncomment the js file again for inline to work. 

View Source in Wygwam to see what the resulting html of the figure and it's classes produce and pick one for now. I'd suggest commenting out line 1537 and switching to class based that way you have full control over your class names since that currently does work and is the better option in the first place for CSS over inline. 

Don't forget to set your custom classes in your CSS file ;-)

## Installation

 1. Copy `system/expressionengine/third_party/wygwam_enhanced_img` folder into your `system/expressionengine/third_party/` directory.
 
 2. Copy `themes/third_party/wygwam_enhanced_img` folder into your `themes/third_party` directory.
 
 3. Turn on the extension under Add-ons -> Extensions in the Control Panel.
 
 4. Optional Settings:
 	- Set image positioning via Inline or Class based CSS - set to Class for the two settings below to take effect (default: Inline)
 	- Set captioned image class name (default: image-captioned)
 	- Set the image class names for left center right positioning - note default format - (default: 'image-left', 'image-center', 'image-right')	
  
## Credit

[CKSource Enhanced Image Plugin](http://ckeditor.com/addon/image2)

[Pixel & Tonic](http://pixelandtonic.com/)

### Change Log ###

**Feb 20, 2015: 0.1**

	Initial Release
	
## Support ##

[Github Issues](https://github.com/Natetronn/wygwam-enhanced-image/issues)

[@natetronn](http://twitter.com/natetronn)


