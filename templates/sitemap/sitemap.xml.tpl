<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	{LOOP VAR(urls)}
		<url>
			<loc>{VAR:loc}</loc>
			<lastmod>{VAR:lastmod}</lastmod>
			<changefreq>{VAR:changefreq}</changefreq>
			<priority>{VAR:priority}</priority>
		</url>
	{ENDLOOP VAR}
</urlset>
