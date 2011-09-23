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
				<ul>
					<li>
						<h3>RequestDataFilter</h3>
						<p>The RequestDataFilter appends all get- and cookie-parameters to the site's source.</p>
					</li>
					<li>
						<h3>LanguageFilter</h3>
						<p>The LanguageFilter extracts the language parameter from the the query string.</p>
					</li>
					<li>
						<h3>PDOInputFilter</h3>
						<p>By the use of the PDOInputFilter you are able to query PDO-supported database and push the results to your site's source.</p>
					</li>
				</ul>

				<h2>Output filters</h2>
				<ul>
					<li>
						<h3>HtmlRenderFilter</h3>
						<p>The HtmlRenderFilter need to be the first filter at the chain and renders the final source document to HTML.</p>
					</li>
				</ul>

				<p>Several filters also combile the <code>InputFilter</code> and <code>OutputFilter</code>.</p>
				<ul>
					<li>
						<h3>CacheFilter</h3>
						<p>Does, what its name states.</p>
					</li>
					<li>
						<h3>DumpFilter</h3>
						<p>The DumpFilter is for debugging purposes and let's have you a look at the site's final source before it gets rendered. It should be disabled at productive environments.</p>
					</li>
					<li>
						<h3>RoutingFilter</h3>
						<p>The RoutingFilter</p>
					</li>
				</ul>
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