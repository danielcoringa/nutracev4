jQuery.noConflict()(function($) {
    "use strict";
    $(document).ready(function() {

        $('p:empty, .nav-next-top:empty, .nav-previous-top:empty').remove();

        $('.sf-menu').css({'display': 'block'});

        $("a").has("img").css({
            "border": "0 none"
        });
        $('#menu-click, .ct-pinterest, .ct-fb, .ct-twitter, .ct-gplus, .follow-block li a, .nav-next a span, .nav-previous a span, .ct-counter, .social-icons-list a, .desc-asc-sort').tooltip('hide');

        $('a.add_to_cart_button').click(function(e) {
            var link = this;
            $(link).parents('.product').find('.overlay-image').addClass('overlay-product-added');

            setTimeout(function() {
                $(link).parents('.product').find('.product-images img').animate({opacity: 0.3});
                $(link).parents('.product').find('.product-added').fadeIn();
            }, 100);
        });

    });
});

/*-------------------------------------------------*/
/*	Pretty Photo
 /*-------------------------------------------------*/
jQuery.noConflict()(function($) {
    "use strict";
    $(document).ready(function() {

        $('a[data-rel]').each(function() {
            $(this).attr('rel', $(this).data('rel'));
        });

        

    });
});


jQuery.noConflict()(function($) {
    "use strict";
    $(document).ready(function() {
        $("<select />").appendTo(".navigation");
        $("<option />", {
            "selected": "selected",
            "value": "",
            "text": "Ir Para..."
        }).appendTo(".navigation select");
        $(".navigation li a").each(function() {
            var el = $(this);
            $("<option />", {
                "value": el.attr("href"),
                "class": "select_option",
                "text": el.text()
            }).appendTo(".navigation select");
        });
        $(".navigation select").change(function() {
            window.location = $(this).find("option:selected").val();
        });
    });
});



/***************************************************
 SuperFish Menu
 ***************************************************/
jQuery.noConflict()(function($) {
    "use strict";
    $('ul.sf-menu').superfish({
        delay: 400,
        autoArrows: true,
        dropShadows: true,
        animation: {opacity: 'show', height: 'show'},
        /*animationOut:  {opacity:'hide'},*/
    });
});


/*-------------------------------------------------*/
/*	CUSTOM BACKGROUND
 /*-------------------------------------------------*/
jQuery(window).load(function() {
    "use strict";
    var theWindow = jQuery(window),
            $bg = jQuery("#bg-stretch"),
            aspectRatio = $bg.width() / $bg.height();

    function resizeBg() {

        if ((theWindow.width() / theWindow.height()) < aspectRatio) {
            $bg
                    .removeClass()
                    .addClass('bg-height');
        } else {
            $bg
                    .removeClass()
                    .addClass('bg-width');
        }

        var pW = (theWindow.width() - $bg.width()) / 2;
        $bg.css("left", pW);
        var pH = (theWindow.height() - $bg.height()) / 2;
        $bg.css("top", pH);

    }

    theWindow.resize(function() {
        resizeBg();
    }).trigger("resize");

});
jQuery(document).ready(function($) {
    var e = moment().format("YYYY-MM-DD HH:mm"), t = moment().subtract("days", 1).format("MMM D, YYYY");
    $(".curr-time").html(e), $(".curr-time").attr("title", e), $(".curr-time").attr("data-original-title", e), $(".yesterday").html(t), $(".yesterday").attr("title", t), $(".yesterday").attr("data-original-title", t), jQuery(".timeago").timeago()
})
jQuery.noConflict()(function($) {
    $(document).ready(function() {
        var $container = $('#blog-entry');
        $container.imagesLoaded(function() {
            $container.masonry({
                itemSelector: '.masonry-box',
                isAnimated: true
            });
        });
        // Infinite Scroll
        $container.infinitescroll({
            navSelector: '.pagination', // selector for the paged navigation
            nextSelector: '.pagination a', // selector for the NEXT link (to page 2)
            itemSelector: '.masonry-box', // selector for all items you'll retrieve
            loading: {
                finishedMsg: 'Nenhum artigo anterior.',
                img: '/img/blog/preloaders/ajax-loader.gif'
            }
        },
        // trigger Masonry as a callback
        function(newElements) {
            var $newElems = $(newElements).css({opacity: 0});
            $newElems.imagesLoaded(function() {
                $newElems.animate({opacity: 1});
                $container.masonry('appended', $newElems, true);
                $('a[data-rel]').each(function() {
                    $(this).attr('rel', $(this).data('rel'));
                });
                
                $('#menu-click, .ct-pinterest, .ct-fb, .ct-twitter, .ct-gplus').tooltip('hide');
                // post like system
                $(".post-like a").click(function() {
                    heart = $(this);
                    post_id = heart.data("post_id");
                    $.ajax({
                        type: "post",
                        url: ajax_var.url,
                        data: "action=post-like&nonce=" + ajax_var.nonce + "&post_like=&post_id=" + post_id,
                        success: function(count) {
                            if (count != "already") {
                                heart.addClass("voted");
                                heart.siblings(".count").text(count);
                            }
                        }
                    });
                    return false;
                }) // end post like system
            });
        });
    });
});
jQuery.noConflict()(function($) {
                "use strict";
                $(document).ready(function() {
                    $('#js-news').ticker({
                        ajaxFeed: false,
                        feedUrl: false,
                        feedType: 'xml',
                        htmlFeed: true,
                        debugMode: false,
                        controls: false,
                        titleText: 'Últimas Notícias :',
                        displayType: 'fade',
                        direction: 'ltr',
                        pauseOnItems: 2000,
                        fadeInSpeed: 600,
                        fadeOutSpeed: 300
                    });
                });
            });
var woocommerce_params = {"countries": "{\"AF\":[],\"AT\":[],\"BE\":[],\"BI\":[],\"CZ\":[],\"DE\":[],\"DK\":[],\"FI\":[],\"FR\":[],\"HU\":[],\"IS\":[],\"IL\":[],\"KR\":[],\"NL\":[],\"NO\":[],\"PL\":[],\"PT\":[],\"SG\":[],\"SK\":[],\"SI\":[],\"LK\":[],\"SE\":[],\"VN\":[],\"AU\":{\"ACT\":\"Australian Capital Territory\",\"NSW\":\"New South Wales\",\"NT\":\"Northern Territory\",\"QLD\":\"Queensland\",\"SA\":\"South Australia\",\"TAS\":\"Tasmania\",\"VIC\":\"Victoria\",\"WA\":\"Western Australia\"},\"BR\":{\"AC\":\"Acre\",\"AL\":\"Alagoas\",\"AP\":\"Amap\u00e1\",\"AM\":\"Amazonas\",\"BA\":\"Bahia\",\"CE\":\"Cear\u00e1\",\"DF\":\"Distrito Federal\",\"ES\":\"Esp\u00edrito Santo\",\"GO\":\"Goi\u00e1s\",\"MA\":\"Maranh\u00e3o\",\"MT\":\"Mato Grosso\",\"MS\":\"Mato Grosso do Sul\",\"MG\":\"Minas Gerais\",\"PA\":\"Par\u00e1\",\"PB\":\"Para\u00edba\",\"PR\":\"Paran\u00e1\",\"PE\":\"Pernambuco\",\"PI\":\"Piau\u00ed\",\"RJ\":\"Rio de Janeiro\",\"RN\":\"Rio Grande do Norte\",\"RS\":\"Rio Grande do Sul\",\"RO\":\"Rond\u00f4nia\",\"RR\":\"Roraima\",\"SC\":\"Santa Catarina\",\"SP\":\"S\u00e3o Paulo\",\"SE\":\"Sergipe\",\"TO\":\"Tocantins\"},\"CA\":{\"AB\":\"Alberta\",\"BC\":\"British Columbia\",\"MB\":\"Manitoba\",\"NB\":\"New Brunswick\",\"NL\":\"Newfoundland\",\"NT\":\"Northwest Territories\",\"NS\":\"Nova Scotia\",\"NU\":\"Nunavut\",\"ON\":\"Ontario\",\"PE\":\"Prince Edward Island\",\"QC\":\"Quebec\",\"SK\":\"Saskatchewan\",\"YT\":\"Yukon Territory\"},\"CN\":{\"CN1\":\"Yunnan \\\/ \u4e91\u5357\",\"CN2\":\"Beijing \\\/ \u5317\u4eac\",\"CN3\":\"Tianjin \\\/ \u5929\u6d25\",\"CN4\":\"Hebei \\\/ \u6cb3\u5317\",\"CN5\":\"Shanxi \\\/ \u5c71\u897f\",\"CN6\":\"Inner Mongolia \\\/ \u5167\u8499\u53e4\",\"CN7\":\"Liaoning \\\/ \u8fbd\u5b81\",\"CN8\":\"Jilin \\\/ \u5409\u6797\",\"CN9\":\"Heilongjiang \\\/ \u9ed1\u9f99\u6c5f\",\"CN10\":\"Shanghai \\\/ \u4e0a\u6d77\",\"CN11\":\"Jiangsu \\\/ \u6c5f\u82cf\",\"CN12\":\"Zhejiang \\\/ \u6d59\u6c5f\",\"CN13\":\"Anhui \\\/ \u5b89\u5fbd\",\"CN14\":\"Fujian \\\/ \u798f\u5efa\",\"CN15\":\"Jiangxi \\\/ \u6c5f\u897f\",\"CN16\":\"Shandong \\\/ \u5c71\u4e1c\",\"CN17\":\"Henan \\\/ \u6cb3\u5357\",\"CN18\":\"Hubei \\\/ \u6e56\u5317\",\"CN19\":\"Hunan \\\/ \u6e56\u5357\",\"CN20\":\"Guangdong \\\/ \u5e7f\u4e1c\",\"CN21\":\"Guangxi Zhuang \\\/ \u5e7f\u897f\u58ee\u65cf\",\"CN22\":\"Hainan \\\/ \u6d77\u5357\",\"CN23\":\"Chongqing \\\/ \u91cd\u5e86\",\"CN24\":\"Sichuan \\\/ \u56db\u5ddd\",\"CN25\":\"Guizhou \\\/ \u8d35\u5dde\",\"CN26\":\"Shaanxi \\\/ \u9655\u897f\",\"CN27\":\"Gansu \\\/ \u7518\u8083\",\"CN28\":\"Qinghai \\\/ \u9752\u6d77\",\"CN29\":\"Ningxia Hui \\\/ \u5b81\u590f\",\"CN30\":\"Macau \\\/ \u6fb3\u95e8\",\"CN31\":\"Tibet \\\/ \u897f\u85cf\",\"CN32\":\"Xinjiang \\\/ \u65b0\u7586\"},\"HK\":{\"HONG KONG\":\"Hong Kong Island\",\"KOWLOON\":\"Kowloon\",\"NEW TERRITORIES\":\"New Territories\"},\"IN\":{\"AP\":\"Andra Pradesh\",\"AR\":\"Arunachal Pradesh\",\"AS\":\"Assam\",\"BR\":\"Bihar\",\"CT\":\"Chhattisgarh\",\"GA\":\"Goa\",\"GJ\":\"Gujarat\",\"HR\":\"Haryana\",\"HP\":\"Himachal Pradesh\",\"JK\":\"Jammu and Kashmir\",\"JH\":\"Jharkhand\",\"KA\":\"Karnataka\",\"KL\":\"Kerala\",\"MP\":\"Madhya Pradesh\",\"MH\":\"Maharashtra\",\"MN\":\"Manipur\",\"ML\":\"Meghalaya\",\"MZ\":\"Mizoram\",\"NL\":\"Nagaland\",\"OR\":\"Orissa\",\"PB\":\"Punjab\",\"RJ\":\"Rajasthan\",\"SK\":\"Sikkim\",\"TN\":\"Tamil Nadu\",\"TR\":\"Tripura\",\"UT\":\"Uttaranchal\",\"UP\":\"Uttar Pradesh\",\"WB\":\"West Bengal\",\"AN\":\"Andaman and Nicobar Islands\",\"CH\":\"Chandigarh\",\"DN\":\"Dadar and Nagar Haveli\",\"DD\":\"Daman and Diu\",\"DL\":\"Delhi\",\"LD\":\"Lakshadeep\",\"PY\":\"Pondicherry (Puducherry)\"},\"ID\":{\"AC\":\"Daerah Istimewa Aceh\",\"SU\":\"Sumatera Utara\",\"SB\":\"Sumatera Barat\",\"RI\":\"Riau\",\"KR\":\"Kepulauan Riau\",\"JA\":\"Jambi\",\"SS\":\"Sumatera Selatan\",\"BB\":\"Bangka Belitung\",\"BE\":\"Bengkulu\",\"LA\":\"Lampung\",\"JK\":\"DKI Jakarta\",\"JB\":\"Jawa Barat\",\"BT\":\"Banten\",\"JT\":\"Jawa Tengah\",\"JI\":\"Jawa Timur\",\"YO\":\"Daerah Istimewa Yogyakarta\",\"BA\":\"Bali\",\"NB\":\"Nusa Tenggara Barat\",\"NT\":\"Nusa Tenggara Timur\",\"KB\":\"Kalimantan Barat\",\"KT\":\"Kalimantan Tengah\",\"KI\":\"Kalimantan Timur\",\"KS\":\"Kalimantan Selatan\",\"KU\":\"Kalimantan Utara\",\"SA\":\"Sulawesi Utara\",\"ST\":\"Sulawesi Tengah\",\"SG\":\"Sulawesi Tenggara\",\"SR\":\"Sulawesi Barat\",\"SN\":\"Sulawesi Selatan\",\"GO\":\"Gorontalo\",\"MA\":\"Maluku\",\"MU\":\"Maluku Utara\",\"PA\":\"Papua\",\"PB\":\"Papua Barat\"},\"MY\":{\"JHR\":\"Johor\",\"KDH\":\"Kedah\",\"KTN\":\"Kelantan\",\"MLK\":\"Melaka\",\"NSN\":\"Negeri Sembilan\",\"PHG\":\"Pahang\",\"PRK\":\"Perak\",\"PLS\":\"Perlis\",\"PNG\":\"Pulau Pinang\",\"SBH\":\"Sabah\",\"SWK\":\"Sarawak\",\"SGR\":\"Selangor\",\"TRG\":\"Terengganu\",\"KUL\":\"W.P. Kuala Lumpur\",\"LBN\":\"W.P. Labuan\",\"PJY\":\"W.P. Putrajaya\"},\"NZ\":{\"NL\":\"Northland\",\"AK\":\"Auckland\",\"WA\":\"Waikato\",\"BP\":\"Bay of Plenty\",\"TK\":\"Taranaki\",\"HB\":\"Hawke\u2019s Bay\",\"MW\":\"Manawatu-Wanganui\",\"WE\":\"Wellington\",\"NS\":\"Nelson\",\"MB\":\"Marlborough\",\"TM\":\"Tasman\",\"WC\":\"West Coast\",\"CT\":\"Canterbury\",\"OT\":\"Otago\",\"SL\":\"Southland\"},\"ZA\":{\"EC\":\"Eastern Cape\",\"FS\":\"Free State\",\"GP\":\"Gauteng\",\"KZN\":\"KwaZulu-Natal\",\"LP\":\"Limpopo\",\"MP\":\"Mpumalanga\",\"NC\":\"Northern Cape\",\"NW\":\"North West\",\"WC\":\"Western Cape\"},\"ES\":{\"C\":\"A Coru\u00f1a\",\"VI\":\"\u00c1lava\",\"AB\":\"Albacete\",\"A\":\"Alicante\",\"AL\":\"Almer\u00eda\",\"O\":\"Asturias\",\"AV\":\"\u00c1vila\",\"BA\":\"Badajoz\",\"PM\":\"Baleares\",\"B\":\"Barcelona\",\"BU\":\"Burgos\",\"CC\":\"C\u00e1ceres\",\"CA\":\"C\u00e1diz\",\"S\":\"Cantabria\",\"CS\":\"Castell\u00f3n\",\"CE\":\"Ceuta\",\"CR\":\"Ciudad Real\",\"CO\":\"C\u00f3rdoba\",\"CU\":\"Cuenca\",\"GI\":\"Girona\",\"GR\":\"Granada\",\"GU\":\"Guadalajara\",\"SS\":\"Guip\u00fazcoa\",\"H\":\"Huelva\",\"HU\":\"Huesca\",\"J\":\"Ja\u00e9n\",\"LO\":\"La Rioja\",\"GC\":\"Las Palmas\",\"LE\":\"Le\u00f3n\",\"L\":\"Lleida\",\"LU\":\"Lugo\",\"M\":\"Madrid\",\"MA\":\"M\u00e1laga\",\"ML\":\"Melilla\",\"MU\":\"Murcia\",\"NA\":\"Navarra\",\"OR\":\"Ourense\",\"P\":\"Palencia\",\"PO\":\"Pontevedra\",\"SA\":\"Salamanca\",\"TF\":\"Santa Cruz de Tenerife\",\"SG\":\"Segovia\",\"SE\":\"Sevilla\",\"SO\":\"Soria\",\"T\":\"Tarragona\",\"TE\":\"Teruel\",\"TO\":\"Toledo\",\"V\":\"Valencia\",\"VA\":\"Valladolid\",\"BI\":\"Vizcaya\",\"ZA\":\"Zamora\",\"Z\":\"Zaragoza\"},\"TH\":{\"TH-37\":\"Amnat Charoen (\u0e2d\u0e33\u0e19\u0e32\u0e08\u0e40\u0e08\u0e23\u0e34\u0e0d)\",\"TH-15\":\"Ang Thong (\u0e2d\u0e48\u0e32\u0e07\u0e17\u0e2d\u0e07)\",\"TH-14\":\"Ayutthaya (\u0e1e\u0e23\u0e30\u0e19\u0e04\u0e23\u0e28\u0e23\u0e35\u0e2d\u0e22\u0e38\u0e18\u0e22\u0e32)\",\"TH-10\":\"Bangkok (\u0e01\u0e23\u0e38\u0e07\u0e40\u0e17\u0e1e\u0e21\u0e2b\u0e32\u0e19\u0e04\u0e23)\",\"TH-38\":\"Bueng Kan (\u0e1a\u0e36\u0e07\u0e01\u0e32\u0e2c)\",\"TH-31\":\"Buri Ram (\u0e1a\u0e38\u0e23\u0e35\u0e23\u0e31\u0e21\u0e22\u0e4c)\",\"TH-24\":\"Chachoengsao (\u0e09\u0e30\u0e40\u0e0a\u0e34\u0e07\u0e40\u0e17\u0e23\u0e32)\",\"TH-18\":\"Chai Nat (\u0e0a\u0e31\u0e22\u0e19\u0e32\u0e17)\",\"TH-36\":\"Chaiyaphum (\u0e0a\u0e31\u0e22\u0e20\u0e39\u0e21\u0e34)\",\"TH-22\":\"Chanthaburi (\u0e08\u0e31\u0e19\u0e17\u0e1a\u0e38\u0e23\u0e35)\",\"TH-50\":\"Chiang Mai (\u0e40\u0e0a\u0e35\u0e22\u0e07\u0e43\u0e2b\u0e21\u0e48)\",\"TH-57\":\"Chiang Rai (\u0e40\u0e0a\u0e35\u0e22\u0e07\u0e23\u0e32\u0e22)\",\"TH-20\":\"Chonburi (\u0e0a\u0e25\u0e1a\u0e38\u0e23\u0e35)\",\"TH-86\":\"Chumphon (\u0e0a\u0e38\u0e21\u0e1e\u0e23)\",\"TH-46\":\"Kalasin (\u0e01\u0e32\u0e2c\u0e2a\u0e34\u0e19\u0e18\u0e38\u0e4c)\",\"TH-62\":\"Kamphaeng Phet (\u0e01\u0e33\u0e41\u0e1e\u0e07\u0e40\u0e1e\u0e0a\u0e23)\",\"TH-71\":\"Kanchanaburi (\u0e01\u0e32\u0e0d\u0e08\u0e19\u0e1a\u0e38\u0e23\u0e35)\",\"TH-40\":\"Khon Kaen (\u0e02\u0e2d\u0e19\u0e41\u0e01\u0e48\u0e19)\",\"TH-81\":\"Krabi (\u0e01\u0e23\u0e30\u0e1a\u0e35\u0e48)\",\"TH-52\":\"Lampang (\u0e25\u0e33\u0e1b\u0e32\u0e07)\",\"TH-51\":\"Lamphun (\u0e25\u0e33\u0e1e\u0e39\u0e19)\",\"TH-42\":\"Loei (\u0e40\u0e25\u0e22)\",\"TH-16\":\"Lopburi (\u0e25\u0e1e\u0e1a\u0e38\u0e23\u0e35)\",\"TH-58\":\"Mae Hong Son (\u0e41\u0e21\u0e48\u0e2e\u0e48\u0e2d\u0e07\u0e2a\u0e2d\u0e19)\",\"TH-44\":\"Maha Sarakham (\u0e21\u0e2b\u0e32\u0e2a\u0e32\u0e23\u0e04\u0e32\u0e21)\",\"TH-49\":\"Mukdahan (\u0e21\u0e38\u0e01\u0e14\u0e32\u0e2b\u0e32\u0e23)\",\"TH-26\":\"Nakhon Nayok (\u0e19\u0e04\u0e23\u0e19\u0e32\u0e22\u0e01)\",\"TH-73\":\"Nakhon Pathom (\u0e19\u0e04\u0e23\u0e1b\u0e10\u0e21)\",\"TH-48\":\"Nakhon Phanom (\u0e19\u0e04\u0e23\u0e1e\u0e19\u0e21)\",\"TH-30\":\"Nakhon Ratchasima (\u0e19\u0e04\u0e23\u0e23\u0e32\u0e0a\u0e2a\u0e35\u0e21\u0e32)\",\"TH-60\":\"Nakhon Sawan (\u0e19\u0e04\u0e23\u0e2a\u0e27\u0e23\u0e23\u0e04\u0e4c)\",\"TH-80\":\"Nakhon Si Thammarat (\u0e19\u0e04\u0e23\u0e28\u0e23\u0e35\u0e18\u0e23\u0e23\u0e21\u0e23\u0e32\u0e0a)\",\"TH-55\":\"Nan (\u0e19\u0e48\u0e32\u0e19)\",\"TH-96\":\"Narathiwat (\u0e19\u0e23\u0e32\u0e18\u0e34\u0e27\u0e32\u0e2a)\",\"TH-39\":\"Nong Bua Lam Phu (\u0e2b\u0e19\u0e2d\u0e07\u0e1a\u0e31\u0e27\u0e25\u0e33\u0e20\u0e39)\",\"TH-43\":\"Nong Khai (\u0e2b\u0e19\u0e2d\u0e07\u0e04\u0e32\u0e22)\",\"TH-12\":\"Nonthaburi (\u0e19\u0e19\u0e17\u0e1a\u0e38\u0e23\u0e35)\",\"TH-13\":\"Pathum Thani (\u0e1b\u0e17\u0e38\u0e21\u0e18\u0e32\u0e19\u0e35)\",\"TH-94\":\"Pattani (\u0e1b\u0e31\u0e15\u0e15\u0e32\u0e19\u0e35)\",\"TH-82\":\"Phang Nga (\u0e1e\u0e31\u0e07\u0e07\u0e32)\",\"TH-93\":\"Phatthalung (\u0e1e\u0e31\u0e17\u0e25\u0e38\u0e07)\",\"TH-56\":\"Phayao (\u0e1e\u0e30\u0e40\u0e22\u0e32)\",\"TH-67\":\"Phetchabun (\u0e40\u0e1e\u0e0a\u0e23\u0e1a\u0e39\u0e23\u0e13\u0e4c)\",\"TH-76\":\"Phetchaburi (\u0e40\u0e1e\u0e0a\u0e23\u0e1a\u0e38\u0e23\u0e35)\",\"TH-66\":\"Phichit (\u0e1e\u0e34\u0e08\u0e34\u0e15\u0e23)\",\"TH-65\":\"Phitsanulok (\u0e1e\u0e34\u0e29\u0e13\u0e38\u0e42\u0e25\u0e01)\",\"TH-54\":\"Phrae (\u0e41\u0e1e\u0e23\u0e48)\",\"TH-83\":\"Phuket (\u0e20\u0e39\u0e40\u0e01\u0e47\u0e15)\",\"TH-25\":\"Prachin Buri (\u0e1b\u0e23\u0e32\u0e08\u0e35\u0e19\u0e1a\u0e38\u0e23\u0e35)\",\"TH-77\":\"Prachuap Khiri Khan (\u0e1b\u0e23\u0e30\u0e08\u0e27\u0e1a\u0e04\u0e35\u0e23\u0e35\u0e02\u0e31\u0e19\u0e18\u0e4c)\",\"TH-85\":\"Ranong (\u0e23\u0e30\u0e19\u0e2d\u0e07)\",\"TH-70\":\"Ratchaburi (\u0e23\u0e32\u0e0a\u0e1a\u0e38\u0e23\u0e35)\",\"TH-21\":\"Rayong (\u0e23\u0e30\u0e22\u0e2d\u0e07)\",\"TH-45\":\"Roi Et (\u0e23\u0e49\u0e2d\u0e22\u0e40\u0e2d\u0e47\u0e14)\",\"TH-27\":\"Sa Kaeo (\u0e2a\u0e23\u0e30\u0e41\u0e01\u0e49\u0e27)\",\"TH-47\":\"Sakon Nakhon (\u0e2a\u0e01\u0e25\u0e19\u0e04\u0e23)\",\"TH-11\":\"Samut Prakan (\u0e2a\u0e21\u0e38\u0e17\u0e23\u0e1b\u0e23\u0e32\u0e01\u0e32\u0e23)\",\"TH-74\":\"Samut Sakhon (\u0e2a\u0e21\u0e38\u0e17\u0e23\u0e2a\u0e32\u0e04\u0e23)\",\"TH-75\":\"Samut Songkhram (\u0e2a\u0e21\u0e38\u0e17\u0e23\u0e2a\u0e07\u0e04\u0e23\u0e32\u0e21)\",\"TH-19\":\"Saraburi (\u0e2a\u0e23\u0e30\u0e1a\u0e38\u0e23\u0e35)\",\"TH-91\":\"Satun (\u0e2a\u0e15\u0e39\u0e25)\",\"TH-17\":\"Sing Buri (\u0e2a\u0e34\u0e07\u0e2b\u0e4c\u0e1a\u0e38\u0e23\u0e35)\",\"TH-33\":\"Sisaket (\u0e28\u0e23\u0e35\u0e2a\u0e30\u0e40\u0e01\u0e29)\",\"TH-90\":\"Songkhla (\u0e2a\u0e07\u0e02\u0e25\u0e32)\",\"TH-64\":\"Sukhothai (\u0e2a\u0e38\u0e42\u0e02\u0e17\u0e31\u0e22)\",\"TH-72\":\"Suphan Buri (\u0e2a\u0e38\u0e1e\u0e23\u0e23\u0e13\u0e1a\u0e38\u0e23\u0e35)\",\"TH-84\":\"Surat Thani (\u0e2a\u0e38\u0e23\u0e32\u0e29\u0e0e\u0e23\u0e4c\u0e18\u0e32\u0e19\u0e35)\",\"TH-32\":\"Surin (\u0e2a\u0e38\u0e23\u0e34\u0e19\u0e17\u0e23\u0e4c)\",\"TH-63\":\"Tak (\u0e15\u0e32\u0e01)\",\"TH-92\":\"Trang (\u0e15\u0e23\u0e31\u0e07)\",\"TH-23\":\"Trat (\u0e15\u0e23\u0e32\u0e14)\",\"TH-34\":\"Ubon Ratchathani (\u0e2d\u0e38\u0e1a\u0e25\u0e23\u0e32\u0e0a\u0e18\u0e32\u0e19\u0e35)\",\"TH-41\":\"Udon Thani (\u0e2d\u0e38\u0e14\u0e23\u0e18\u0e32\u0e19\u0e35)\",\"TH-61\":\"Uthai Thani (\u0e2d\u0e38\u0e17\u0e31\u0e22\u0e18\u0e32\u0e19\u0e35)\",\"TH-53\":\"Uttaradit (\u0e2d\u0e38\u0e15\u0e23\u0e14\u0e34\u0e15\u0e16\u0e4c)\",\"TH-95\":\"Yala (\u0e22\u0e30\u0e25\u0e32)\",\"TH-35\":\"Yasothon (\u0e22\u0e42\u0e2a\u0e18\u0e23)\"},\"US\":{\"AL\":\"Alabama\",\"AK\":\"Alaska\",\"AZ\":\"Arizona\",\"AR\":\"Arkansas\",\"CA\":\"California\",\"CO\":\"Colorado\",\"CT\":\"Connecticut\",\"DE\":\"Delaware\",\"DC\":\"District Of Columbia\",\"FL\":\"Florida\",\"GA\":\"Georgia\",\"HI\":\"Hawaii\",\"ID\":\"Idaho\",\"IL\":\"Illinois\",\"IN\":\"Indiana\",\"IA\":\"Iowa\",\"KS\":\"Kansas\",\"KY\":\"Kentucky\",\"LA\":\"Louisiana\",\"ME\":\"Maine\",\"MD\":\"Maryland\",\"MA\":\"Massachusetts\",\"MI\":\"Michigan\",\"MN\":\"Minnesota\",\"MS\":\"Mississippi\",\"MO\":\"Missouri\",\"MT\":\"Montana\",\"NE\":\"Nebraska\",\"NV\":\"Nevada\",\"NH\":\"New Hampshire\",\"NJ\":\"New Jersey\",\"NM\":\"New Mexico\",\"NY\":\"New York\",\"NC\":\"North Carolina\",\"ND\":\"North Dakota\",\"OH\":\"Ohio\",\"OK\":\"Oklahoma\",\"OR\":\"Oregon\",\"PA\":\"Pennsylvania\",\"RI\":\"Rhode Island\",\"SC\":\"South Carolina\",\"SD\":\"South Dakota\",\"TN\":\"Tennessee\",\"TX\":\"Texas\",\"UT\":\"Utah\",\"VT\":\"Vermont\",\"VA\":\"Virginia\",\"WA\":\"Washington\",\"WV\":\"West Virginia\",\"WI\":\"Wisconsin\",\"WY\":\"Wyoming\",\"AA\":\"Armed Forces (AA)\",\"AE\":\"Armed Forces (AE)\",\"AP\":\"Armed Forces (AP)\",\"AS\":\"American Samoa\",\"GU\":\"Guam\",\"MP\":\"Northern Mariana Islands\",\"PR\":\"Puerto Rico\",\"UM\":\"US Minor Outlying Islands\",\"VI\":\"US Virgin Islands\"}}", "plugin_url": "http:\/\/elite-themes.com\/lynx\/wp-content\/plugins\/woocommerce", "ajax_url": "\/artigos\/page\/0", "ajax_loader_url": "\/img\/blog\/ajax-loader@2x.gif", "i18n_select_state_text": "Select an option\u2026", "i18n_required_rating_text": "Please select a rating", "i18n_no_matching_variations_text": "Sorry, no products matched your selection. Please choose a different combination.", "i18n_required_text": "required", "i18n_view_cart": "View Cart \u2192", "review_rating_required": "yes", "update_order_review_nonce": "fdc0434d9b", "apply_coupon_nonce": "50afa27ea3", "option_guest_checkout": "yes", "checkout_url": "\/artigos\/page\/0?action=woocommerce-checkout", "is_checkout": "0", "update_shipping_method_nonce": "bb6362f4b2", "cart_url": "http:\/\/elite-themes.com\/lynx\/cart\/", "cart_redirect_after_add": "no"};