<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" exclude-result-prefixes="sitemap">
	<xsl:output method="html" encoding="UTF-8" indent="yes"/>
	<xsl:variable name="has-lastmod" select="count( /sitemap:sitemapindex/sitemap:sitemap/sitemap:lastmod )"/>
	<xsl:template match="/">
		<html lang="en-US">
			<head>
				<title>XML Sitemap</title>
				<style type="text/css">body{font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#545353}table{border:0;border-collapse:collapse}#sitemap tr.odd{background-color:#eee}#sitemap tbody tr:hover{background-color:#eee}#sitemap tbody tr:hover td,#sitemap tbody tr:hover td a{color:#000}#content{margin:0 auto;width:100%;max-width:1000px}.expl{margin:10px 3px;line-height:1.3em}.expl a{color:#da3114;font-weight:bold}a{color:#000;text-decoration:none}a:visited{color:#777}a:hover{text-decoration:underline}td{font-size:12px;padding:4px}th{text-align:left;font-size:12px;padding:4px;padding-right:30px;}table{border:1px solid #ccc;}thead th{border-bottom:1px solid #ccc;cursor:pointer;background-color:#eee}tbody td{border-bottom:1px solid #ccc;}</style>
			</head>
			<body>
				<div id="content">
					<h1>XML Sitemap</h1>
					<p class="expl">Generated using PHP, this is an XML Sitemap, meant for consumption by search engines. This is the XML Sitemap Index to aid search engines like <a target="_blank" href="https://google.com">Google</a>, <a target="_blank" href="https://bing.com">Bing</a>, <a target="_blank" href="https://yahoo.com">Yahoo!</a> and <a target="_blank" href="https://ask.com">Ask</a> indexing your site better. You can find more information about XML sitemaps on <a href="http://sitemaps.org">sitemaps.org</a>.</p>
					<p class="expl">This sitemap contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> URLs.</p>
					<table id="sitemap" width="100%" cellpadding="3">
						<thead>
							<tr>
								<th width="100%">URL</th>
								<xsl:if test="$has-lastmod">
									<th class="lastmod">Last Modified</th>
								</xsl:if>
							</tr>
						</thead>
						<tbody>
							<xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
								<tr>
									<td class="loc"><a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc" /></a></td>
									<xsl:if test="$has-lastmod">
										<td class="lastmod"><xsl:value-of select="sitemap:lastmod" /></td>
									</xsl:if>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
