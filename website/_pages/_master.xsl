<?xml version="1.0"?>
<!DOCTYPE xsl:stylesheet [
  <!ENTITY nbsp "&#160;">
]>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<!-- XML output mode -->

	<!--
	<xsl:output method="xml" standalone="yes" indent="no" encoding="utf-8"/>
	-->
<xsl:output method="html"
media-type="text/html"
omit-xml-declaration="yes"
encoding="UTF-8"
indent="yes"
extension-element-prefixes="exsl"/>


	<!-- we do not need spaces in output file -->
	<!--
	<xsl:strip-space elements="*"/>
	-->
 
	<!-- Main page template --> 
	<xsl:template match="/chainr">
		<xsl:text disable-output-escaping="yes">&lt;</xsl:text>!DOCTYPE html<xsl:text disable-output-escaping="yes">&gt;</xsl:text>
		<html> 
		<head> 
			<title><xsl:value-of select="/chainr/website/title"/></title>

			<!-- // Always force latest IE rendering engine (even in intranet)
			     // and Chrome Frame Remove this if you use the .htaccess -->
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

			<!-- // Place favicon.ico and apple-touch-icon.png in the root of
			     // your domain and delete these references -->
			<link rel="shortcut icon" href="{$root}/favicon.ico" />

			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.5/dojo/dojo.xd.js">
				<xsl:comment>Unhide</xsl:comment>
			</script>

			<script type="text/javascript" src="{$root}/assets/vendor/modernizr-1.5.min.js">
				<xsl:comment>Unhide</xsl:comment>
			</script>

			<link rel="stylesheet" href="{$root}/assets/vendor/blueprint/screen.css" type="text/css" media="screen, projection" />
			<link rel="stylesheet" href="{$root}/assets/vendor/blueprint/print.css" type="text/css" media="print" />
			<link rel="stylesheet" href="{$root}/assets/css/master.css" type="text/css" media="screen, projection" />
			
			<!-- // Enforce IE9 to behave like IE8 -->
			<meta http-equiv="X-UA-Compatible" content="IE=8" />

			<xsl:call-template name="additional-headers" />
		</head> 
		<body>
			<section class="container">
				<!-- // Page header // -->
				<header class="page prepend-top span-23 last">
					<xsl:call-template name="page-header" />
				</header>
				
				<xsl:apply-templates select="navigation[@id='main']" />

				<section id="content" class="prepend-1 span-14 append-1 last">
					<xsl:apply-templates select="//available_languages" />

					<xsl:call-template name="content" />

					<footer class="page pull-1 span-16 last">
						<div>
							<xsl:call-template name="page-footer" />
						</div>
					</footer>
				</section>
			</section>
			
			<script><![CDATA[
				dojo.require("dojox.highlight");
				dojo.require("dojox.highlight.languages.xml");

				dojo.ready(function() {
					;
				});
			]]></script>
		</body> 
		</html> 
	</xsl:template>

	<!-- // Navigation // -->
	<xsl:template match="/chainr/navigation">
		<nav class="main span-6 append-1">
			<xsl:apply-templates select="item" />
		</nav>
	</xsl:template>

	<!-- // Navigation item // -->
	<xsl:template match="/chainr/navigation/item">
		<xsl:element name="a">
			<xsl:attribute name="href">
				<xsl:value-of select="$root" />
				<xsl:text>/</xsl:text>
				<xsl:value-of select="@id" />
			</xsl:attribute>
			<xsl:attribute name="class">
				<xsl:text>tk-magion-web</xsl:text>
			</xsl:attribute>
			<xsl:if test="@id=$page">
				<xsl:attribute name="class">active</xsl:attribute>
			</xsl:if>
			<xsl:value-of select="." />
		</xsl:element>
	</xsl:template>

	<xsl:template match="//filter[@id='languageFilter']/available_languages">
		<nav class="languages">
			<xsl:apply-templates select="language" />
		</nav>
	</xsl:template>

	<xsl:template match="//filter[@id='languageFilter']/available_languages/language">
		<xsl:element name="a">
			<xsl:attribute name="href">
				<xsl:text>?language=</xsl:text>
				<xsl:value-of select="@key" />
			</xsl:attribute>
			<!-- // Highlight current language // -->
			<xsl:if test="//filter[@id='languageFilter']/current_language=@key">
				<xsl:attribute name="class">
					<xsl:text>active</xsl:text>
				</xsl:attribute>
			</xsl:if>
			<xsl:value-of select="." />
		</xsl:element>
	</xsl:template>

	<!-- // i18n template -->
	<xsl:template name="i18n">
		<xsl:param name="language" select="'en'" />
		<xsl:param name="content" />

		<xsl:if test="//filter[@id='languageFilter']/current_language=$language">
			<xsl:copy-of select="$content" />
		</xsl:if>
	</xsl:template>

	<!-- // Page header // -->
	<xsl:template name="page-header">
		<h1 class="title">chainr</h1>
		<h2 class="subtitle">simple but powerful</h2>
	</xsl:template>

	<!-- // Page footer // -->
	<xsl:template name="page-footer">
		Copyright 2010 Christian Schmitz, Soulworks GmbH. All rights reserved.
	</xsl:template>

	<xsl:template name="content">
		<h1>no content</h1>
	</xsl:template>

	<xsl:template name="additional-headers">
		<xsl:comment>Additional headers</xsl:comment>
	</xsl:template>

</xsl:stylesheet>