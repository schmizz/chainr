<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="_master.xsl"/>

<xsl:template name="content">
	<article>
		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'en'" />
			<xsl:with-param name="content">
				<header><h1>Welcome</h1></header>
				<h2 class="teaser">Hi, welcome to the website of <span class="chainr">chainr</span>.</h2>
				<p>Chainr is a simple XSLT- and PHP-based toolchain for creating small websites without any great efforts.</p>
			</xsl:with-param>
		</xsl:call-template>

		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'de'" />
			<xsl:with-param name="content">
				<header><h1>Willkommen</h1></header>
				<h2 class="teaser">Hi, willkommen auf der Website von <span class="chainr">chainr</span>.</h2>
			</xsl:with-param>
		</xsl:call-template>
	</article>
</xsl:template>

</xsl:stylesheet>