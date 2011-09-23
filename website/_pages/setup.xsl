<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:exsl="http://exslt.org/common">

<xsl:import href="_master.xsl"/>

<xsl:template name="content">
	<article>
		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'en'" />
			<xsl:with-param name="content">
				<header><h1>Setup</h1></header>
				<h2 class="teaser"></h2>

<h2>Prepare .htaccess</h2>
<code><pre class="brush: js;"><![CDATA[
<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteBase /

	# If the file/symlink/directory does not exist => Redirect to index.php
	# Important note: If you copy/paste this into httpd.conf instead
	# of .htaccess you will need to add ‘%{DOCUMENT_ROOT}’ left to each
	# ‘%{REQUEST_FILENAME}’ part.
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-l

	# For use with the RealUrl extension, you might need to remove the
	# RewriteBase directive somewhere above and use this line instead of the
	# next one:
	RewriteRule ^(.*/?)$ ./index.php?path=$1&%{QUERY_STRING} [NC,L]
</IfModule>
]]></pre></code>

<h2>Prepare index.php</h2>
<code><pre class="brush: js;"><![CDATA[
// Enable strict error reporting
error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

require('../app/lib/Chainr.class.php');

// Boorstrap Chainr
Chainr::bootstrap();

try {
	// Create a suspension from the site's source
	$site = Chainr::createSuspension('./chainr.xml');

	// Attach filters
	$site->registerFilter(new Chainr_Filter_HtmlRenderFilter(array(
	    'pages_dir' => './pages/'
	)));
	$site->registerFilter(new Chainr_Filter_DumpFilter());
	$site->registerFilter(new Chainr_Filter_LanguageFilter(array(
		 'languages'        => array('de' => 'Deutsch', 'en' => 'English'),
		 'default_language' => 'de'
	)));
	$site->registerFilter(new Chainr_Filter_RequestDataFilter());
	$site->registerFilter(new Chainr_Filter_RoutingFilter());

	$site->render();
} catch(Chainr_Exception $e) {
	Chainr::prettifyException($e);
} catch(Exception $e) {
	Chainr::prettifyException($e);
}
]]></pre></code>

<h2>Prepare index.php</h2>
<code><pre class="brush: js;"><![CDATA[
	<ala>xxx</ala>
]]></pre></code>

			</xsl:with-param>
		</xsl:call-template>

		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'de'" />
			<xsl:with-param name="content">
				<header><h1>Setup</h1></header>
				<h2 class="teaser">.</h2>
			</xsl:with-param>
		</xsl:call-template>
	</article>
</xsl:template>

</xsl:stylesheet>