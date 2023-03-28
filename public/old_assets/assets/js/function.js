// my-js //



$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

$('#home-slider').on('initialized.owl.carousel changed.owl.carousel', function(e) {
    if (!e.namespace) {
        return;
    }
    var carousel = e.relatedTarget;
    $('.slider-counter').text('0' + carousel.relative(carousel.current() + 1));

}).owlCarousel({
    items: 1,
    loop: true,
    margin: 0,
    nav: true,
    dots: false
});




// document.getElementById("b").addEventListener('click', function() {
//     document.getElementById("b").innerHTML = "Complete";
//     document.getElementById("b").style.background = "#52b68d";
//     document.getElementById("b").style.color = "white";
// })


$("#profileImage").click(function(e) {
    $("#imageUpload").click();
});

function fasterPreview(uploader) {
    if (uploader.files && uploader.files[0]) {
        $('#profileImage').attr('src',
            window.URL.createObjectURL(uploader.files[0]));
    }
}

$("#imageUpload").change(function() {
    fasterPreview(this);
});



$('.owl-carousel').owlCarousel({
    items: 4,
    loop: true,
    margin: 10,
    // autoplay: true,
    responsiveClass: true,
    responsive: {
        0: {
            items: 2,
            nav: true,
            loop: true
        },
        600: {
            items: 3,
            nav: false,
            loop: true
        },
        1000: {
            items: 4,
            nav: true,
            loop: true
        }
    }
})



var theToggle = document.getElementById('toggle');

// based on Todd Motto functions
// https://toddmotto.com/labs/reusable-js/

// hasClass
function hasClass(elem, className) {
    return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}
// addClass
function addClass(elem, className) {
    if (!hasClass(elem, className)) {
        elem.className += ' ' + className;
    }
}
// removeClass
function removeClass(elem, className) {
    var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(' ' + className + ' ') >= 0) {
            newClass = newClass.replace(' ' + className + ' ', ' ');
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    }
}
// toggleClass
function toggleClass(elem, className) {
    var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, " ") + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(" " + className + " ") >= 0) {
            newClass = newClass.replace(" " + className + " ", " ");
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    } else {
        elem.className += ' ' + className;
    }
}

// theToggle.onclick = function() {
//     toggleClass(this, 'on');
//     return false;
// }

function up(max) {
    document.getElementById("myNumber").value = parseInt(document.getElementById("myNumber").value) + 1;
    if (document.getElementById("myNumber").value >= parseInt(max)) {
        document.getElementById("myNumber").value = max;
    }
}

function down(min) {
    document.getElementById("myNumber").value = parseInt(document.getElementById("myNumber").value) - 1;
    if (document.getElementById("myNumber").value <= parseInt(min)) {
        document.getElementById("myNumber").value = min;
    }
}

function up(max) {
    document.getElementById("myNumber2").value = parseInt(document.getElementById("myNumber2").value) + 1;
    if (document.getElementById("myNumber2").value >= parseInt(max)) {
        document.getElementById("myNumber2").value = max;
    }
}

function down(min) {
    document.getElementById("myNumber2").value = parseInt(document.getElementById("myNumber2").value) - 1;
    if (document.getElementById("myNumber2").value <= parseInt(min)) {
        document.getElementById("myNumber2").value = min;
    }
}


//I added event handler for the file upload control to access the files properties.
document.addEventListener("DOMContentLoaded", init, false);

//To save an array of attachments
var AttachmentArray = [];

//counter for attachment array
var arrCounter = 0;

//to make sure the error message for number of files will be shown only one time.
var filesCounterAlertStatus = false;

//un ordered list to keep attachments thumbnails
var ul = document.createElement("ul");
ul.className = "thumb-Images";
ul.id = "imgList";

function init() {
    //add javascript handlers for the file upload event
    document
        .querySelector("#files")
        .addEventListener("change", handleFileSelect, false);
}

//the handler for file upload event
function handleFileSelect(e) {
    //to make sure the user select file/files
    if (!e.target.files) return;

    //To obtaine a File reference
    var files = e.target.files;

    // Loop through the FileList and then to render image files as thumbnails.
    for (var i = 0, f;
        (f = files[i]); i++) {
        //instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = (function(readerEvt) {
            return function(e) {
                //Apply the validation rules for attachments upload
                ApplyFileValidationRules(readerEvt);

                //Render attachments thumbnails.
                RenderThumbnail(e, readerEvt);

                //Fill the array of attachment
                FillAttachmentArray(e, readerEvt);
            };
        })(f);

        // Read in the image file as a data URL.
        // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
        // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
        fileReader.readAsDataURL(f);
    }
    document
        .getElementById("files")
        .addEventListener("change", handleFileSelect, false);
}

//To remove attachment once user click on x button
jQuery(function($) {
    $("div").on("click", ".img-wrap .close", function() {
        var id = $(this)
            .closest(".img-wrap")
            .find("img")
            .data("id");

        //to remove the deleted item from array
        var elementPos = AttachmentArray.map(function(x) {
            return x.FileName;
        }).indexOf(id);
        if (elementPos !== -1) {
            AttachmentArray.splice(elementPos, 1);
        }

        //to remove image tag
        $(this)
            .parent()
            .find("img")
            .not()
            .remove();

        //to remove div tag that contain the image
        $(this)
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove div tag that contain caption name
        $(this)
            .parent()
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove li tag
        var lis = document.querySelectorAll("#imgList li");
        for (var i = 0;
            (li = lis[i]); i++) {
            if (li.innerHTML == "") {
                li.parentNode.removeChild(li);
            }
        }
    });
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
    //To check file type according to upload conditions
    if (CheckFileType(readerEvt.type) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, You can only upload jpg/png/gif files"
        );
        e.preventDefault();
        return;
    }

    //To check file Size according to upload conditions
    if (CheckFileSize(readerEvt.size) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
        );
        e.preventDefault();
        return;
    }

    //To check files count according to upload conditions
    if (CheckFilesCount(AttachmentArray) == false) {
        if (!filesCounterAlertStatus) {
            filesCounterAlertStatus = true;
            alert(
                "You have added more than 10 files. According to upload conditions you can upload 10 files maximum"
            );
        }
        e.preventDefault();
        return;
    }
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
    if (fileType == "image/jpeg") {
        return true;
    } else if (fileType == "image/png") {
        return true;
    } else if (fileType == "image/gif") {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
    if (fileSize < 300000) {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check files count according to upload conditions
function CheckFilesCount(AttachmentArray) {
    //Since AttachmentArray.length return the next available index in the array,
    //I have used the loop to get the real length
    var len = 0;
    for (var i = 0; i < AttachmentArray.length; i++) {
        if (AttachmentArray[i] !== undefined) {
            len++;
        }
    }
    //To check the length does not exceed 10 files maximum
    if (len > 9) {
        return false;
    } else {
        return true;
    }
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt) {
    var li = document.createElement("li");
    ul.appendChild(li);
    li.innerHTML = [
        '<div class="img-wrap"> <span class="close">&times;</span>' +
        '<img class="thumb" src="',
        e.target.result,
        '" title="',
        escape(readerEvt.name),
        '" data-id="',
        readerEvt.name,
        '"/>' + "</div>"
    ].join("");

    var div = document.createElement("div");
    div.className = "FileNameCaptionStyle";
    li.appendChild(div);
    div.innerHTML = [readerEvt.name].join("");
    document.getElementById("Filelist").insertBefore(ul, null);
}

//Fill the array of attachment
function FillAttachmentArray(e, readerEvt) {
    AttachmentArray[arrCounter] = {
        AttachmentType: 1,
        ObjectType: 1,
        FileName: readerEvt.name,
        FileDescription: "Attachment",
        NoteText: "",
        MimeType: readerEvt.type,
        Content: e.target.result.split("base64,")[1],
        FileSizeInBytes: readerEvt.size
    };
    arrCounter = arrCounter + 1;
}




var txt = document.getElementById('txt');
var list = document.getElementById('list');
var items = ['PHP', 'React.js', 'WordPress'];

txt.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        let val = txt.value;
        if (val !== '') {
            if (items.indexOf(val) >= 0) {
                alert('Tag name is a duplicate');
            } else {
                items.push(val);
                render();
                txt.value = '';
                txt.focus();
            }
        } else {
            alert('Please type a tag Name');
        }
    }
});

function render() {
    list.innerHTML = '';
    items.map((item, index) => {
        list.innerHTML += `<li><span>${item}</span><a href="javascript: remove(${index})">X</a></li>`;
    });
}

function remove(i) {
    items = items.filter(item => items.indexOf(item) != i);
    render();
}

window.onload = function() {
    render();
    txt.focus();
}





function up(max) {
    document.getElementById("myNumber").value = parseInt(document.getElementById("myNumber").value) + 1;
    if (document.getElementById("myNumber").value >= parseInt(max)) {
        document.getElementById("myNumber").value = max;
    }
}

function down(min) {
    document.getElementById("myNumber").value = parseInt(document.getElementById("myNumber").value) - 1;
    if (document.getElementById("myNumber").value <= parseInt(min)) {
        document.getElementById("myNumber").value = min;
    }
}



//I added event handler for the file upload control to access the files properties.
document.addEventListener("DOMContentLoaded", init, false);

//To save an array of attachments
var AttachmentArray = [];

//counter for attachment array
var arrCounter = 0;

//to make sure the error message for number of files will be shown only one time.
var filesCounterAlertStatus = false;

//un ordered list to keep attachments thumbnails
var ul = document.createElement("ul");
ul.className = "thumb-Images";
ul.id = "imgList";

function init() {
    //add javascript handlers for the file upload event
    document
        .querySelector("#files")
        .addEventListener("change", handleFileSelect, false);
}

//the handler for file upload event
function handleFileSelect(e) {
    //to make sure the user select file/files
    if (!e.target.files) return;

    //To obtaine a File reference
    var files = e.target.files;

    // Loop through the FileList and then to render image files as thumbnails.
    for (var i = 0, f;
        (f = files[i]); i++) {
        //instantiate a FileReader object to read its contents into memory
        var fileReader = new FileReader();

        // Closure to capture the file information and apply validation.
        fileReader.onload = (function(readerEvt) {
            return function(e) {
                //Apply the validation rules for attachments upload
                ApplyFileValidationRules(readerEvt);

                //Render attachments thumbnails.
                RenderThumbnail(e, readerEvt);

                //Fill the array of attachment
                FillAttachmentArray(e, readerEvt);
            };
        })(f);

        // Read in the image file as a data URL.
        // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
        // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
        fileReader.readAsDataURL(f);
    }
    document
        .getElementById("files")
        .addEventListener("change", handleFileSelect, false);
}

//To remove attachment once user click on x button
jQuery(function($) {
    $("div").on("click", ".img-wrap .close", function() {
        var id = $(this)
            .closest(".img-wrap")
            .find("img")
            .data("id");

        //to remove the deleted item from array
        var elementPos = AttachmentArray.map(function(x) {
            return x.FileName;
        }).indexOf(id);
        if (elementPos !== -1) {
            AttachmentArray.splice(elementPos, 1);
        }

        //to remove image tag
        $(this)
            .parent()
            .find("img")
            .not()
            .remove();

        //to remove div tag that contain the image
        $(this)
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove div tag that contain caption name
        $(this)
            .parent()
            .parent()
            .find("div")
            .not()
            .remove();

        //to remove li tag
        var lis = document.querySelectorAll("#imgList li");
        for (var i = 0;
            (li = lis[i]); i++) {
            if (li.innerHTML == "") {
                li.parentNode.removeChild(li);
            }
        }
    });
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
    //To check file type according to upload conditions
    if (CheckFileType(readerEvt.type) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, You can only upload jpg/png/gif files"
        );
        e.preventDefault();
        return;
    }

    //To check file Size according to upload conditions
    if (CheckFileSize(readerEvt.size) == false) {
        alert(
            "The file (" +
            readerEvt.name +
            ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
        );
        e.preventDefault();
        return;
    }

    //To check files count according to upload conditions
    if (CheckFilesCount(AttachmentArray) == false) {
        if (!filesCounterAlertStatus) {
            filesCounterAlertStatus = true;
            alert(
                "You have added more than 10 files. According to upload conditions you can upload 10 files maximum"
            );
        }
        e.preventDefault();
        return;
    }
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
    if (fileType == "image/jpeg") {
        return true;
    } else if (fileType == "image/png") {
        return true;
    } else if (fileType == "image/gif") {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
    if (fileSize < 300000) {
        return true;
    } else {
        return false;
    }
    return true;
}

//To check files count according to upload conditions
function CheckFilesCount(AttachmentArray) {
    //Since AttachmentArray.length return the next available index in the array,
    //I have used the loop to get the real length
    var len = 0;
    for (var i = 0; i < AttachmentArray.length; i++) {
        if (AttachmentArray[i] !== undefined) {
            len++;
        }
    }
    //To check the length does not exceed 10 files maximum
    if (len > 9) {
        return false;
    } else {
        return true;
    }
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt) {
    var li = document.createElement("li");
    ul.appendChild(li);
    li.innerHTML = [
        '<div class="img-wrap"> <span class="close">&times;</span>' +
        '<img class="thumb" src="',
        e.target.result,
        '" title="',
        escape(readerEvt.name),
        '" data-id="',
        readerEvt.name,
        '"/>' + "</div>"
    ].join("");

    var div = document.createElement("div");
    div.className = "FileNameCaptionStyle";
    li.appendChild(div);
    div.innerHTML = [readerEvt.name].join("");
    document.getElementById("Filelist").insertBefore(ul, null);
}

//Fill the array of attachment
function FillAttachmentArray(e, readerEvt) {
    AttachmentArray[arrCounter] = {
        AttachmentType: 1,
        ObjectType: 1,
        FileName: readerEvt.name,
        FileDescription: "Attachment",
        NoteText: "",
        MimeType: readerEvt.type,
        Content: e.target.result.split("base64,")[1],
        FileSizeInBytes: readerEvt.size
    };
    arrCounter = arrCounter + 1;
}

// my-js end//





$("input[type=number]").keydown(function(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl/cmd+A
        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: Ctrl/cmd+C
        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: Ctrl/cmd+X
        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});


//
//function setNextButton(event) {
//	event.preventDefault();
//	const ids = ["csfb-span", "cnfb-span", "cpb-span"]
//	const {id} = event.target;
//	if(!id) return;
//	let buttons = document.querySelectorAll(".ntBtn");
//	buttons.forEach(item => {
//		if(id.includes(item.id)) {
//			item.classList.remove("d-none");
//			document.getElementById(`${item.id}-checkmark`).checked = true;
//		}
//		else {
//			item.classList.add("d-none");			
//		}
//	})
//}
// 

/*custom accordian show hide start here*/

//const handleIcon = (icon, classToRemove, classToAdd) => {
//			icon.classList.remove(classToRemove);
//			icon.classList.add(classToAdd);								
//}
//
//const handleHint = (hint, classToRemove, classToAdd) => {
//			classToRemove.length ? hint.classList.remove(classToRemove) : null;
//			classToAdd.length ? hint.classList.add(classToAdd) : null;								
//}
//
//const registerDivClick = (divId, iconId, hintId) => {
//	let div = document.getElementById(divId);
//	div.onclick= function () {
//		let icon = document.getElementById(iconId);
//		let hint = document.getElementById(hintId);
//		setTimeout(() => {
//			if(div.classList.value.includes("collapsed"))
//			{
//			handleIcon(icon, 'fa-angle-down', 'fa-angle-right');
//			handleHint(hint, '', 'd-none');
//		}
//			else
//		{
//			handleIcon(icon, 'fa-angle-right','fa-angle-down')		
//			handleHint(hint, 'd-none', '')			
//		}
//	}, 100)	
//}
//}
//
//try {
//	registerDivClick("friendly-bet-accordian-div", "icon-friendly-bet", "hint-friendly-bet");
//	registerDivClick("pool-bet-accordian-div", "icon-pool-bet", "hint-pool-bet");
//}
//catch(e) {
//	console.log(e)
//}



/*custom accordian end hide start here*/



/*scroll bar start here*/

//(function($){
//			$(window).on("load",function(){
//				
//				$(".scroll-bar").mCustomScrollbar();
//				
//				$(".disable-destroy a").click(function(e){
//					e.preventDefault();
//					var $this=$(this),
//						rel=$this.attr("rel"),
//						el=$(".scroll-bar"),
//						output=$("#info > p code");
//					switch(rel){
//						case "toggle-disable":
//						case "toggle-disable-no-reset":
//							if(el.hasClass("mCS_disabled")){
//								el.mCustomScrollbar("update");
//								output.text("$(\".scroll-bar\").mCustomScrollbar(\"update\");");
//							}else{
//								var reset=rel==="toggle-disable-no-reset" ? false : true;
//								el.mCustomScrollbar("disable",reset);
//								if(reset){
//									output.text("$(\".scroll-bar\").mCustomScrollbar(\"disable\",true);");
//								}else{
//									output.text("$(\".content\").mCustomScrollbar(\"disable\");");
//								}
//							}
//							break;
//						case "toggle-destroy":
//							if(el.hasClass("mCS_destroyed")){
//								el.mCustomScrollbar();
//								output.text("$(\".scroll-bar\").mCustomScrollbar();");
//							}else{
//								el.mCustomScrollbar("destroy");
//								output.text("$(\".scroll-bar\").mCustomScrollbar(\"destroy\");");
//							}
//							break;
//					}
//				});
//				
//			});
//		})(jQuery);



/*scroll bar end here*/


/*time picker start her*/
//
// $('#timepicker-1').timepicker({
//   uiLibrary: 'bootstrap4'
// });
// 
/*time picker end her*/
/*date picker start here*/

//
// 
// 
// $('#datepicker-2').datepicker({
//   uiLibrary: 'bootstrap4'
// }); 

/*
 





 
$('#datepicker-13').datepicker({
            uiLibrary: 'bootstrap4'
});

 $('#datepicker-14').datepicker({
            uiLibrary: 'bootstrap4'
});

 $('#datepicker-15').datepicker({
            uiLibrary: 'bootstrap4'
});

 $('#datepicker-16').datepicker({
            uiLibrary: 'bootstrap4'
});

 $('#datepicker-17').datepicker({
            uiLibrary: 'bootstrap4'
}); 
$('#datepicker-18').datepicker({
            uiLibrary: 'bootstrap4'
});

 $('#datepicker-19').datepicker({
            uiLibrary: 'bootstrap4'
});*/
/*date picker end here*/

/*modal click change start here*/

//$(function(){
//	
//    $('#submit-report').on('click', function(){
//        $('.friendly-bet-report-modal').modal('hide');
//        $('.submit-report-modal-thank').modal('show');
//    }); 
//
//}); 


/*modal click change end here*/


/*ck editor start here*/

// try{

//     CKEDITOR.replace( 'editorr', {
//         customConfig: '/ckeditor_settings/config.js',
//     });
// 	CKEDITOR.editorConfig = function( config )
//     {
//         config.height = '100px';
//     };

// }
// catch(e){
//     console.log(e);
// }


/*ck editor end here*/

/*slider start here*/

// 	jQuery( '#home' ).owlCarousel( {
// 	loop: true,
// 	margin: 0,
// 	autoplay: true,
// 	autoplayTimeout: 3000,
// 	autoplayHoverPause: true,
// 	responsiveClass: true,
// 	responsive: {
// 		0: {
// 			items: 1,
// 			nav: true
// 		},
// 		600: {
// 			items: 1,
// 			nav: false
// 		},
// 		1000: {
// 			items: 1,
// 			nav: false,

// 		}
// 	}
// } );
/*slider end here*/


/*nav start here*/


!(function(n, i, e, a) {
    (n.navigation = function(t, s) {
        var o = {
                responsive: !0,
                mobileBreakpoint: 991,
                showDuration: 200,
                hideDuration: 200,
                showDelayDuration: 0,
                hideDelayDuration: 0,
                submenuTrigger: "hover",
                effect: "fade",
                submenuIndicator: !0,
                submenuIndicatorTrigger: !1,
                hideSubWhenGoOut: !0,
                visibleSubmenusOnMobile: !1,
                fixed: !1,
                overlay: !0,
                overlayColor: "rgba(0, 0, 0, 0.5)",
                hidden: !1,
                hiddenOnMobile: !1,
                offCanvasSide: "left",
                offCanvasCloseButton: !0,
                animationOnShow: "",
                animationOnHide: "",
                onInit: function() {},
                onLandscape: function() {},
                onPortrait: function() {},
                onShowOffCanvas: function() {},
                onHideOffCanvas: function() {}
            },
            r = this,
            u = Number.MAX_VALUE,
            d = 1,
            l = "click.nav touchstart.nav",
            f = "mouseenter focusin",
            c = "mouseleave focusout";
        r.settings = {};
        var t = (n(t), t);
        n(t).find(".nav-search").length > 0 &&
            n(t)
            .find(".nav-search")
            .find("form")
            .prepend(
                "<span class='nav-search-close-button' tabindex='0'>&#10005;</span>"
            ),
            (r.init = function() {
                (r.settings = n.extend({}, o, s)),
                r.settings.offCanvasCloseButton &&
                    n(t)
                    .find(".nav-menus-wrapper")
                    .prepend(
                        "<span class='nav-menus-wrapper-close-button'>&#10005;</span>"
                    ),
                    "right" == r.settings.offCanvasSide &&
                    n(t)
                    .find(".nav-menus-wrapper")
                    .addClass("nav-menus-wrapper-right"),
                    r.settings.hidden &&
                    (n(t).addClass("navigation-hidden"),
                        (r.settings.mobileBreakpoint = 99999)),
                    v(),
                    r.settings.fixed && n(t).addClass("navigation-fixed"),
                    n(t)
                    .find(".nav-toggle")
                    .on("click touchstart", function(n) {
                        n.stopPropagation(),
                            n.preventDefault(),
                            r.showOffcanvas(),
                            s !== a && r.callback("onShowOffCanvas");
                    }),
                    n(t)
                    .find(".nav-menus-wrapper-close-button")
                    .on("click touchstart", function() {
                        r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas");
                    }),
                    n(t)
                    .find(".nav-search-button, .nav-search-close-button")
                    .on("click touchstart keydown", function(i) {
                        i.stopPropagation(), i.preventDefault();
                        var e = i.keyCode || i.which;
                        "click" === i.type ||
                            "touchstart" === i.type ||
                            ("keydown" === i.type && 13 == e) ?
                            r.toggleSearch() :
                            9 == e && n(i.target).blur();
                    }),
                    n(t).find(".megamenu-tabs").length > 0 && y(),
                    n(i).resize(function() {
                        r.initNavigationMode(C()), O(), r.settings.hiddenOnMobile && m();
                    }),
                    r.initNavigationMode(C()),
                    r.settings.hiddenOnMobile && m(),
                    s !== a && r.callback("onInit");
            });
        var h = function() {
                n(t)
                    .find(".nav-submenu")
                    .hide(0),
                    n(t)
                    .find("li")
                    .removeClass("focus");
            },
            v = function() {
                n(t)
                    .find("li")
                    .each(function() {
                        n(this).children(".nav-dropdown,.megamenu-panel").length > 0 &&
                            (n(this)
                                .children(".nav-dropdown,.megamenu-panel")
                                .addClass("nav-submenu"),
                                r.settings.submenuIndicator &&
                                n(this)
                                .children("a")
                                .append(
                                    "<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"
                                ));
                    });
            },
            m = function() {
                n(t).hasClass("navigation-portrait") ?
                    n(t).addClass("navigation-hidden") :
                    n(t).removeClass("navigation-hidden");
            };
        (r.showSubmenu = function(i, e) {
            C() > r.settings.mobileBreakpoint &&
                n(t)
                .find(".nav-search")
                .find("form")
                .fadeOut(),
                "fade" == e ?
                n(i)
                .children(".nav-submenu")
                .stop(!0, !0)
                .delay(r.settings.showDelayDuration)
                .fadeIn(r.settings.showDuration)
                .removeClass(r.settings.animationOnHide)
                .addClass(r.settings.animationOnShow) :
                n(i)
                .children(".nav-submenu")
                .stop(!0, !0)
                .delay(r.settings.showDelayDuration)
                .slideDown(r.settings.showDuration)
                .removeClass(r.settings.animationOnHide)
                .addClass(r.settings.animationOnShow),
                n(i).addClass("focus");
        }),
        (r.hideSubmenu = function(i, e) {
            "fade" == e
                ?
                n(i)
                .find(".nav-submenu")
                .stop(!0, !0)
                .delay(r.settings.hideDelayDuration)
                .fadeOut(r.settings.hideDuration)
                .removeClass(r.settings.animationOnShow)
                .addClass(r.settings.animationOnHide) :
                n(i)
                .find(".nav-submenu")
                .stop(!0, !0)
                .delay(r.settings.hideDelayDuration)
                .slideUp(r.settings.hideDuration)
                .removeClass(r.settings.animationOnShow)
                .addClass(r.settings.animationOnHide),
                n(i)
                .removeClass("focus")
                .find(".focus")
                .removeClass("focus");
        });
        var p = function() {
                n("body").addClass("no-scroll"),
                    r.settings.overlay &&
                    (n(t).append("<div class='nav-overlay-panel'></div>"),
                        n(t)
                        .find(".nav-overlay-panel")
                        .css("background-color", r.settings.overlayColor)
                        .fadeIn(300)
                        .on("click touchstart", function(n) {
                            r.hideOffcanvas();
                        }));
            },
            g = function() {
                n("body").removeClass("no-scroll"),
                    r.settings.overlay &&
                    n(t)
                    .find(".nav-overlay-panel")
                    .fadeOut(400, function() {
                        n(this).remove();
                    });
            };
        (r.showOffcanvas = function() {
            p(),
                "left" == r.settings.offCanvasSide ?
                n(t)
                .find(".nav-menus-wrapper")
                .css("transition-property", "left")
                .addClass("nav-menus-wrapper-open") :
                n(t)
                .find(".nav-menus-wrapper")
                .css("transition-property", "right")
                .addClass("nav-menus-wrapper-open");
        }),
        (r.hideOffcanvas = function() {
            n(t)
                .find(".nav-menus-wrapper")
                .removeClass("nav-menus-wrapper-open")
                .on(
                    "webkitTransitionEnd moztransitionend transitionend oTransitionEnd",
                    function() {
                        n(t)
                            .find(".nav-menus-wrapper")
                            .css("transition-property", "none")
                            .off();
                    }
                ),
                g();
        }),
        (r.toggleOffcanvas = function() {
            C() <= r.settings.mobileBreakpoint &&
                (n(t)
                    .find(".nav-menus-wrapper")
                    .hasClass("nav-menus-wrapper-open") ?
                    (r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas")) :
                    (r.showOffcanvas(), s !== a && r.callback("onShowOffCanvas")));
        }),
        (r.toggleSearch = function() {
            "none" ==
            n(t)
                .find(".nav-search")
                .find("form")
                .css("display") ?
                (n(t)
                    .find(".nav-search")
                    .find("form")
                    .fadeIn(200),
                    n(t)
                    .find(".nav-search")
                    .find("input")
                    .focus()) :
                (n(t)
                    .find(".nav-search")
                    .find("form")
                    .fadeOut(200),
                    n(t)
                    .find(".nav-search")
                    .find("input")
                    .blur());
        }),
        (r.initNavigationMode = function(i) {
            r.settings.responsive ?
                (i <= r.settings.mobileBreakpoint &&
                    u > r.settings.mobileBreakpoint &&
                    (n(t)
                        .addClass("navigation-portrait")
                        .removeClass("navigation-landscape"),
                        S(),
                        s !== a && r.callback("onPortrait")),
                    i > r.settings.mobileBreakpoint &&
                    d <= r.settings.mobileBreakpoint &&
                    (n(t)
                        .addClass("navigation-landscape")
                        .removeClass("navigation-portrait"),
                        k(),
                        g(),
                        r.hideOffcanvas(),
                        s !== a && r.callback("onLandscape")),
                    (u = i),
                    (d = i)) :
                (n(t).addClass("navigation-landscape"),
                    k(),
                    s !== a && r.callback("onLandscape"));
        });
        var b = function() {
                n("html").on("click.body touchstart.body", function(i) {
                    0 === n(i.target).closest(".navigation").length &&
                        (n(t)
                            .find(".nav-submenu")
                            .fadeOut(),
                            n(t)
                            .find(".focus")
                            .removeClass("focus"),
                            n(t)
                            .find(".nav-search")
                            .find("form")
                            .fadeOut());
                });
            },
            C = function() {
                return (
                    i.innerWidth || e.documentElement.clientWidth || e.body.clientWidth
                );
            },
            w = function() {
                n(t)
                    .find(".nav-menu")
                    .find("li, a")
                    .off(l)
                    .off(f)
                    .off(c);
            },
            O = function() {
                if (C() > r.settings.mobileBreakpoint) {
                    var i = n(t).outerWidth(!0);
                    n(t)
                        .find(".nav-menu")
                        .children("li")
                        .children(".nav-submenu")
                        .each(function() {
                            n(this)
                                .parent()
                                .position().left +
                                n(this).outerWidth() >
                                i ?
                                n(this).css("right", 0) :
                                n(this).css("right", "auto");
                        });
                }
            },
            y = function() {
                function i(i) {
                    var e = n(i)
                        .children(".megamenu-tabs-nav")
                        .children("li"),
                        a = n(i).children(".megamenu-tabs-pane");
                    n(e).on("click.tabs touchstart.tabs", function(i) {
                        i.stopPropagation(),
                            i.preventDefault(),
                            n(e).removeClass("active"),
                            n(this).addClass("active"),
                            n(a)
                            .hide(0)
                            .removeClass("active"),
                            n(a[n(this).index()])
                            .show(0)
                            .addClass("active");
                    });
                }
                if (n(t).find(".megamenu-tabs").length > 0)
                    for (var e = n(t).find(".megamenu-tabs"), a = 0; a < e.length; a++)
                        i(e[a]);
            },
            k = function() {
                w(),
                    h(),
                    navigator.userAgent.match(/Mobi/i) ||
                    navigator.maxTouchPoints > 0 ||
                    "click" == r.settings.submenuTrigger ?
                    n(t)
                    .find(".nav-menu, .nav-dropdown")
                    .children("li")
                    .children("a")
                    .on(l, function(e) {
                        if (
                            (r.hideSubmenu(
                                    n(this)
                                    .parent("li")
                                    .siblings("li"),
                                    r.settings.effect
                                ),
                                n(this)
                                .closest(".nav-menu")
                                .siblings(".nav-menu")
                                .find(".nav-submenu")
                                .fadeOut(r.settings.hideDuration),
                                n(this).siblings(".nav-submenu").length > 0)
                        ) {
                            if (
                                (e.stopPropagation(),
                                    e.preventDefault(),
                                    "none" ==
                                    n(this)
                                    .siblings(".nav-submenu")
                                    .css("display"))
                            )
                                return (
                                    r.showSubmenu(n(this).parent("li"), r.settings.effect),
                                    O(), !1
                                );
                            if (
                                (r.hideSubmenu(n(this).parent("li"), r.settings.effect),
                                    "_blank" === n(this).attr("target") ||
                                    "blank" === n(this).attr("target"))
                            )
                                i.open(n(this).attr("href"));
                            else {
                                if (
                                    "#" === n(this).attr("href") ||
                                    "" === n(this).attr("href") ||
                                    "javascript:void(0)" === n(this).attr("href")
                                )
                                    return !1;
                                i.location.href = n(this).attr("href");
                            }
                        }
                    }) :
                    n(t)
                    .find(".nav-menu")
                    .find("li")
                    .on(f, function() {
                        r.showSubmenu(this, r.settings.effect), O();
                    })
                    .on(c, function() {
                        r.hideSubmenu(this, r.settings.effect);
                    }),
                    r.settings.hideSubWhenGoOut && b();
            },
            S = function() {
                w(),
                    h(),
                    r.settings.visibleSubmenusOnMobile ?
                    n(t)
                    .find(".nav-submenu")
                    .show(0) :
                    (n(t)
                        .find(".submenu-indicator")
                        .removeClass("submenu-indicator-up"),
                        r.settings.submenuIndicator && r.settings.submenuIndicatorTrigger ?
                        n(t)
                        .find(".submenu-indicator")
                        .on(l, function(i) {
                            return (
                                i.stopPropagation(),
                                i.preventDefault(),
                                r.hideSubmenu(
                                    n(this)
                                    .parent("a")
                                    .parent("li")
                                    .siblings("li"),
                                    "slide"
                                ),
                                r.hideSubmenu(
                                    n(this)
                                    .closest(".nav-menu")
                                    .siblings(".nav-menu")
                                    .children("li"),
                                    "slide"
                                ),
                                "none" ==
                                n(this)
                                .parent("a")
                                .siblings(".nav-submenu")
                                .css("display") ?
                                (n(this).addClass("submenu-indicator-up"),
                                    n(this)
                                    .parent("a")
                                    .parent("li")
                                    .siblings("li")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    n(this)
                                    .closest(".nav-menu")
                                    .siblings(".nav-menu")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    r.showSubmenu(
                                        n(this)
                                        .parent("a")
                                        .parent("li"),
                                        "slide"
                                    ), !1) :
                                (n(this)
                                    .parent("a")
                                    .parent("li")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    void r.hideSubmenu(
                                        n(this)
                                        .parent("a")
                                        .parent("li"),
                                        "slide"
                                    ))
                            );
                        }) :
                        n(t)
                        .find(".nav-menu, .nav-dropdown")
                        .children("li")
                        .children("a")
                        .on(l, function(e) {
                            if (
                                (e.stopPropagation(),
                                    e.preventDefault(),
                                    r.hideSubmenu(
                                        n(this)
                                        .parent("li")
                                        .siblings("li"),
                                        r.settings.effect
                                    ),
                                    r.hideSubmenu(
                                        n(this)
                                        .closest(".nav-menu")
                                        .siblings(".nav-menu")
                                        .children("li"),
                                        "slide"
                                    ),
                                    "none" ==
                                    n(this)
                                    .siblings(".nav-submenu")
                                    .css("display"))
                            )
                                return (
                                    n(this)
                                    .children(".submenu-indicator")
                                    .addClass("submenu-indicator-up"),
                                    n(this)
                                    .parent("li")
                                    .siblings("li")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    n(this)
                                    .closest(".nav-menu")
                                    .siblings(".nav-menu")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    r.showSubmenu(n(this).parent("li"), "slide"), !1
                                );
                            if (
                                (n(this)
                                    .parent("li")
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    r.hideSubmenu(n(this).parent("li"), "slide"),
                                    "_blank" === n(this).attr("target") ||
                                    "blank" === n(this).attr("target"))
                            )
                                i.open(n(this).attr("href"));
                            else {
                                if (
                                    "#" === n(this).attr("href") ||
                                    "" === n(this).attr("href") ||
                                    "javascript:void(0)" === n(this).attr("href")
                                )
                                    return !1;
                                i.location.href = n(this).attr("href");
                            }
                        }));
            };
        (r.callback = function(n) {
            s[n] !== a && s[n].call(t);
        }),
        r.init();
    }),
    (n.fn.navigation = function(i) {
        return this.each(function() {
            if (a === n(this).data("navigation")) {
                var e = new n.navigation(this, i);
                n(this).data("navigation", e);
            }
        });
    });
})(jQuery, window, document);



(function($) {
    'use strict';

    var $window = $(window);

    if ($.fn.navigation) {
        $("#navigation1").navigation();
        $("#always-hidden-nav").navigation({
            hidden: true
        });
    }

    $window.on('load', function() {
        $('#preloader').fadeOut('slow', function() {
            $(this).remove();
        });
    });

})(jQuery);
/*nav end here*/