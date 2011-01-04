<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="_master.xsl"/>

<xsl:template name="content">
	<article>
		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'de'" />
			<xsl:with-param name="content">
				<header><h1>Kontakt</h1></header>
			</xsl:with-param>
		</xsl:call-template>
		
		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'en'" />
			<xsl:with-param name="content">
				<header><h1>Contact</h1></header>
			</xsl:with-param>
		</xsl:call-template>
	</article>
</xsl:template>

</xsl:stylesheet>