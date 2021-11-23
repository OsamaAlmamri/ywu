module.exports = {
	globDirectory: 'public/site',
	globPatterns: [
		'**/*.{mp3,pdf,jpg,png,PNG,jpeg,css,eot,svg,ttf,woff,woff2,otf,ico,js,pty,gif,php,txt,json,html,flow,zip,scss,md,less,swf,bootstrap,lock,yml,nuspec,ps1,jshintrc,htm,ts,tab,sh,coffee,markdown,config,apk}'
	],
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	],
	swDest: 'public/sw.js'
};
