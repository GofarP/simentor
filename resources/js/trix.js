document.addEventListener("trix-initialize", function (event) {
    const toolbar = event.target.toolbarElement;

    // Enable bullet & number list
    if (toolbar) {
        toolbar.querySelectorAll(
            "button[data-trix-attribute='bullet'], button[data-trix-attribute='number']"
        ).forEach(btn => btn.removeAttribute("disabled"));
    }

    // Heading 1
    Trix.config.blockAttributes.heading1 = {
        tagName: "h1",
        terminal: true,
        breakOnReturn: true,
        group: false
    };

    // Code block
    Trix.config.blockAttributes.code = {
        tagName: "pre",
        terminal: true,
        breakOnReturn: true,
        group: false
    };

    // Quote block
    Trix.config.blockAttributes.quote = {
        tagName: "blockquote",
        terminal: true,
        breakOnReturn: true,
        group: false
    };
});
