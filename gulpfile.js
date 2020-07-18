const { src, dest, watch } = require("gulp");
const less = require("gulp-less");
const css = require("gulp-clean-css");
const rename = require("gulp-rename");
const pkg = require("./package.json");

function extensionStyle() {
    return src("./custom/*.less")
        .pipe(less())
        .pipe(css())
        .pipe(rename(`${pkg.name}.min.css`))
        .pipe(dest("dist"));
}

watch(["./custom/*.less"], function(cb) {
    return extensionStyle()
});

exports.default = extensionStyle;
