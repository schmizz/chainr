<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="_master.xsl"/>

<xsl:template name="content">
	<article>

		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'en'" />
			<xsl:with-param name="content">
				<header><h1>Development</h1></header>
				<h2 class="teaser">Development</h2>
			</xsl:with-param>
		</xsl:call-template>

		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'de'" />
			<xsl:with-param name="content">
				<header><h1>Development</h1></header>
				<h2 class="teaser">Development</h2>
			</xsl:with-param>
		</xsl:call-template>

	</article>
</xsl:template>

</xsl:stylesheet>