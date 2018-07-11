var mobile=0;
var sim=0;

$(function() {
    App.init();
});
var App = {
    init: function() {
                this.datetime(), this.side.nav(), this.search.bar(), this.navigation(), this.hyperlinks(), setInterval("App.datetime();", 1e3)
    },
    datetime: function() {

        //////////////////////////////////////
        ///////////////////////////////////
var sundte = new Date
var yeardte = sundte.getFullYear();
var monthdte = sundte.getMonth();
var dtedte = sundte.getDate();
var daydte = sundte.getDay();
var sunyear
switch (daydte) {
    case 0:
        var today = "يکشنبه";
        break;
    case 1:
        var today = "دوشنبه";
        break;
    case 2:
        var today = "سه شنبه";
        break;
    case 3:
        var today = "چهارشنبه";
        break;
    case 4:
        var today = "پنچشنبه";
        break;
    case 5:
        var today = "جمعه";
        break;
    case 6:
        var today = "شنبه";
        break;
}
switch (monthdte) {
    case 0:

        sunyear = yeardte - 622;
        if (dtedte <= 20) {
            var sunmonth = "دي";
            var daysun = dtedte + 10;
        } else {
            var sunmonth = "بهمن";
            var daysun = dtedte - 20;
        }
        break;
    case 1:

        sunyear = yeardte - 622;
        if (dtedte <= 19) {
            var sunmonth = "بهمن";
            var daysun = dtedte + 11;
        } else {
            var sunmonth = "اسفند";
            var daysun = dtedte - 19;
        }
        break;
    case 2:
        {
            if ((yeardte - 621) % 4 == 0)
                var i = 10;
            else
                var i = 9;
            if (dtedte <= 20) {
                sunyear = yeardte - 622;
                var sunmonth = "اسفند";
                var daysun = dtedte + i;
            } else {
                sunyear = yeardte - 621;
                var sunmonth = "فروردين";
                var daysun = dtedte - 20;
            }
        }
        break;
    case 3:

        sunyear = yeardte - 621;
        if (dtedte <= 20) {
            var sunmonth = "فروردين";
            var daysun = dtedte + 11;
        } else {
            var sunmonth = "ارديبهشت";
            var daysun = dtedte - 20;
        }
        break;
    case 4:

        sunyear = yeardte - 621;
        if (dtedte <= 21) {
            var sunmonth = "ارديبهشت";
            var daysun = dtedte + 10;
        } else {
            var sunmonth = "خرداد";
            var daysun = dtedte - 21;
        }

        break;
    case 5:

        sunyear = yeardte - 621;
        if (dtedte <= 21) {
            var sunmonth = "خرداد";
            var daysun = dtedte + 10;
        } else {
            var sunmonth = "تير";
            var daysun = dtedte - 21;
        }
        break;
    case 6:

        sunyear = yeardte - 621;
        if (dtedte <= 22) {
            var sunmonth = "تير";
            var daysun = dtedte + 9;
        } else {
            var sunmonth = "مرداد";
            var daysun = dtedte - 22;
        }
        break;
    case 7:

        sunyear = yeardte - 621;
        if (dtedte <= 22) {
            var sunmonth = "مرداد";
            var daysun = dtedte + 9;
        } else {
            var sunmonth = "شهريور";
            var daysun = dtedte - 22;
        }
        break;
    case 8:

        sunyear = yeardte - 621;
        if (dtedte <= 22) {
            var sunmonth = "شهريور";
            var daysun = dtedte + 9;
        } else {
            var sunmonth = "مهر";
            var daysun = dtedte + 22;
        }
        break;
    case 9:

        sunyear = yeardte - 621;
        if (dtedte <= 22) {
            var sunmonth = "مهر";
            var daysun = dtedte + 8;
        } else {
            var sunmonth = "آبان";
            var daysun = dtedte - 22;
        }
        break;
    case 10:

        sunyear = yeardte - 621;
        if (dtedte <= 21) {
            var sunmonth = "آبان";
            var daysun = dtedte + 9;
        } else {
            var sunmonth = "آذر";
            var daysun = dtedte - 21;
        }

        break;
    case 11:

        sunyear = yeardte - 621;
        if (dtedte <= 19) {
            var sunmonth = "آذر";
            var daysun = dtedte + 9;
        } else {
            var sunmonth = "دي";
            var daysun = dtedte + 21;
        }
        break;

}
///////////////////////////////////////////////





                var e = new Array("یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنجشنبه", "جمعه", "شنبه"),
                            t = new Array("دی", "بهمن", "اسفند", "فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر"),
                            a = new Date,
                            i = a.getYear()-621;
                1e3 > i && (i += 1900);
                var s = a.getDay(),
                            n = a.getMonth(),
                            r = a.getDate();
                10 > r && (r = "0" + r);
                var l = a.getHours(),
                            c = a.getMinutes(),
                            h = a.getSeconds(),
                            o = "AM";
                l >= 12 && (o = "PM"), l > 12 && (l -= 12), 0 == l && (l = 12), 9 >= c && (c = "0" + c), 9 >= h && (h = "0" + h), $(".welcome .datetime .day").text(e[s]), $(".welcome .datetime .date").text(sunmonth + " " +sunyear+"," + daysun), $(".welcome .datetime .time").text(l + ":" + c + ":" + h + " " + o)
    },
    title: function(e) {
                return $(".header>.title").text(e)
    },
    side: {
                nav: function() {
                            this.toggle(), this.navigation()
                },
                toggle: function() {
                            $(".ion-ios-navicon").on("touchstart click", function(e) {
                                        e.preventDefault(), $(".sidebar").toggleClass("active"), $(".nav").removeClass("active"), $(".sidebar .sidebar-overlay").removeClass("fadeOut animated").addClass("fadeIn animated")
                            }), $(".sidebar .sidebar-overlay").on("touchstart click", function(e) {
                                        e.preventDefault(), $(".ion-ios-navicon").click(), $(this).removeClass("fadeIn").addClass("fadeOut")
                            })
                },
                navigation: function() {
                            $(".nav-left a").on("touchstart click", function(e) {
                                        e.preventDefault();
                                        var t = $(this).attr("href").replace("#", "");
                                      //  $(".sidebar").toggleClass("active"), $(".html").removeClass("visible"), "home" == t || "" == t || null == t ? $(".html.welcome").addClass("visible") : $(".html." + t).addClass("visible"), App.title($(this).text())
                                      if(mobile==0 && t=="mobile"){
                                        $("#apple").show(100);
                                        $("#samsung").show(200);
                                        $("#nokia").show(300);
                                        $("#htc").show(400);
                                        $("#others").show(500);
                                        $("#mobile").toggleClass("fa-caret-right fa-caret-down");
                                        mobile=1;
                                    }else{
                                        if(t=="mobile"){
                                        $("#others").hide(100);
                                        $("#htc").hide(200);
                                        $("#nokia").hide(300);
                                        $("#samsung").hide(400);
                                        $("#apple").hide(500);
                                        $("#mobile").toggleClass("fa-caret-right fa-caret-down");
                                        mobile=0;
                                        }
                                    }
                                    ///////////////////
                                    if(sim==0 && t=="sim"){
                                        $("#mci").show(100);
                                        $("#mtn").show(200);
                                        $("#rightel").show(300);
                                        $("#sim").toggleClass("fa-caret-right fa-caret-down");
                                        sim=1;
                                    }else{
                                        if(t=="sim"){
                                        $("#mci").hide(100);
                                        $("#mtn").hide(200);
                                        $("#rightel").hide(300);
                                        $("#sim").toggleClass("fa-caret-right fa-caret-down");
                                        sim=0;
                                        }
                                
                                    }
                            })
                }
    },
    search: {
                bar: function() {
                            $(".header .ion-ios-search").on("touchstart click", function() {
                                        var e = ($(".header .search input").hasClass("search-visible"), $(".header .search input").val());
                                        return "" != e && null != e ? (App.search.html($(".header .search input").val()), !1) : ($(".nav").removeClass("active"), $(".header .search input").focus(), void $(".header .search input").toggleClass("search-visible"))
                            }), $(".search form").on("submit", function(e) {
                                        e.preventDefault(), App.search.html($(".header .search input").val())
                            })
                },
                html: function(e) {
                            $(".search input").removeClass("search-visible"), $(".html").removeClass("visible"), $(".html.search").addClass("visible"), App.title("Result"), $(".html.search").html($(".html.search").html()), $(".html.search .key").html(e), $(".header .search input").val("")
                }
    },
    navigation: function() {
                $(".nav .mask").on("touchstart click", function(e) {
                            e.preventDefault(), $(this).parent().toggleClass("active")
                })
    },
    hyperlinks: function() {
                $(".nav .nav-item").on("click", function(e) {
                            e.preventDefault();
                            var t = $(this).attr("href").replace("#", "");
                            $(".html").removeClass("visible"), $(".html." + t).addClass("visible"), $(".nav").toggleClass("active"), App.title($(this).text())
                })
    }
};

function goTo(url){
    setTimeout(function(){window.location.replace(url);},2);
  }
  