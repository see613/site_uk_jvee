
$(function() {
    var appName = '';
    var shareInfo = {
        twitter: {
            url: 'https://twitter.com/intent/tweet?',
            params: {
                url: 'url',
                text: 'title'
            }
        },
        facebook: {
            url: 'https://www.facebook.com/sharer/sharer.php?src=sp&',
            params: {
                u: 'url'
            },
            openGraph: {
                title: 'title',
                description: 'preview',
                image: 'image'
            }
        },
        googleplus: {
            url: 'https://plus.google.com/share?',
            params: {
                url: 'url'
            },
            openGraph: {
                title: 'title',
                description: 'preview',
                image: 'image'
            }
        },
        linkedin: {
            url: 'https://www.linkedin.com/shareArticle?mini=true&source=' +encodeURIComponent(appName)+ '&',
            params: {
                url: 'url',
                title: 'title',
                summary: 'preview'
            },
            openGraph: {
                image: 'image'
            }
        },
        email: {
            url: 'mailto:?',
            params: {
                subject: 'title',
                body: 'url'
            }
        }
    };
    var entryData = {
        url: '',
        title: '',
        preview: '',
        image: ''
    };
    var resultUrl, type, id;


    $('body').on('click', '.share-button', function() {
        var entrySelector = $(this).data('entry-selector');
        var $entry = $(this).parents(entrySelector);
        var $image = $entry.find('.image');

        type = $(this).data('share-type');
        entryData.url = prepareParam( $entry.data('url').trim() );
        entryData.title = prepareParam( $entry.find('.title').text().trim() );
        entryData.preview = prepareParam( $entry.find('.preview').text().trim() );
        entryData.image = $image.length>0 ? prepareParam( $image.attr('src').trim() ) : '';

        resultUrl = buildUrl();

        if (type == 'email') {
            window.open(resultUrl);
        }
        else {
            openWindow(resultUrl);
        }

        return false;
    });

    function buildUrl() {
        return shareInfo[type].url + buildParams();
    }

    function buildParams() {
        if ( !shareInfo[type].hasOwnProperty('params') ) {
            return '';
        }

        var params = [];
        var obj = shareInfo[type].params;
        var i = 0;

        for (var prop in obj) {
            if( obj.hasOwnProperty(prop) ) {
                params[i] = prop+ '=' +entryData[ obj[prop] ];
            }
            i++;
        }

        return params.join('&');
    }

    function prepareParam(param) {
        if ( param.hasOwnProperty('trim') ) {
            param = param.trim();
        }
        return encodeURIComponent( param );
    }

    function openWindow(url) {
        window.open(url, "share_popup","scrollbars=1,resizable=1,menubar=0,toolbar=0,status=0").focus();
    }


});
