function incNumber(targetSpanClass) {
    var spans = document.querySelectorAll('.' + targetSpanClass);
    spans.forEach(function(span) {
        var currentValue = parseInt(span.textContent);
        span.textContent = currentValue + 1 <= 10 ? currentValue + 1 : 10;
        document.getElementById(targetSpanClass).value = currentValue + 1 <= 10 ? currentValue + 1 : 10;
    });
}

function decNumber(targetSpanClass) {
    var spans = document.querySelectorAll('.' + targetSpanClass);
    spans.forEach(function(span) {
        var currentValue = parseInt(span.textContent);
        span.textContent = currentValue - 1 >= 0 ? currentValue - 1 : 0;
        document.getElementById(targetSpanClass).value = currentValue - 1 >= 0 ? currentValue - 1 : 0;
    });
}
