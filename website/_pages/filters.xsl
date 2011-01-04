<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="_master.xsl"/>

<xsl:template name="content">
	<article>
		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'en'" />
			<xsl:with-param name="content">
				<header><h1>Chains and filters</h1></header>

				<p>The processing of requests in <span class="chainr">chainr</span> takes place in so called filters. There are two types of filters currently: <code>InputFilter</code>s and <code>OutputFilter</code>s. The filters get called in the order of they were added to the <code>Suspension</code>.</p>

				<h2>Input filters</h2>

				<h2>Output filters</h2>
			</xsl:with-param>
		</xsl:call-template>

		<xsl:call-template name="i18n">
			<xsl:with-param name="language" select="'de'" />
			<xsl:with-param name="content">
				<header><h1>Filter</h1></header>
				<h2 class="teaser"> <span class="chainr">chainr</span>.</h2>
			</xsl:with-param>
		</xsl:call-template>
	</article>
</xsl:template>

</xsl:stylesheet>