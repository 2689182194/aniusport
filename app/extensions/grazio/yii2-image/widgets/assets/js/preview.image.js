/**
 * Created by ezsky on 16/5/23.
 * see https://github.com/andrewng330/PreviewImage/tree/master
 */
(function ($) {
    $.fn.previewimage = function (setting) {
        var setting = $.extend({
            container: "",
            imgsize: "",
            ext: "jpg/jpeg/png"
        }, setting);
        var origin = $(this);
        var name = origin.prop("name");
        var container = $(setting.container);
        if (origin.length && container.length && name !== "") {

            origin.on("change", function (e) {

                var input = this;
                var inputfile = this.files;
                if (inputfile && inputfile[0]) {

                    if (CheckExt(inputfile[0].name, setting.ext) && CheckSize(inputfile[0].size, setting.imgsize)) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var src = e.target.result;
                            var img = CreateImage(src);
                            container.empty();
                            container.prepend(img);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                    else {
                        // alert("您的图像后缀不符合或文件尺寸太大");
                    }
                }
            });
        }
        else if (!origin.length) {
            throw "Cannot find selector or selector is not an input file type";
        }
        else if (!container.length) {
            throw "Target container cannot be found";
        }
        else if (name == "") {
            throw "Name attribute is not defined in input file type";
        }


    };

    function CreateDisplay(src, ie) {


        var display = document.createElement("figure");
        if (ie) {
            var method = "scale";
            var scale = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "',sizingMethod=" + method + ")";
            display.style.filter = scale;
        }
        else {
            display.style.backgroundImage = "url(" + src + ")";
        }

        return display;
    }
    function CreateImage(src, ie) {


        var display = document.createElement("img");

            display.src = src ;

        return display;
    }

    function CheckSize(InputSize, set_Size) {
        var set_Size = parseInt(set_Size);
        var InputToMB = InputSize / 10485760;
        return (isNaN(set_Size) || InputToMB <= set_Size) ? true : false;
    }

    function CheckExt(filename, set_ext) {
        var ext = filename.substr((~-filename.lastIndexOf(".") >>> 0) + 2);
        var set_array = set_ext.split("/");
        for (var i = set_array.length - 1; i >= 0; i--) {
            if (ext == set_array[i]) {
                return true;
            }
        }
        ;
        return false;
    }
})(jQuery);