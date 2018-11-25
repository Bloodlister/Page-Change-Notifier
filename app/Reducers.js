const {JSDOM} = require('jsdom');

class Reducer {
    constructor(html) {
        this.title = '';
        this.desc = '';
        this.image = '';
        this.link = '';
        this.price = '';

        this.dom = new JSDOM(html);
        this.setTitle();
        this.setDescription();
        this.setImage();
        this.setLink();
        this.setPrice();
    }

    setTitle() {
        throw Error("Not Implemented");
    }

    setDescription() {
        throw Error("Not Implemented");
    }

    setImage() {
        throw Error("Not Implemented");
    }

    setLink() {
        throw Error("Not Implemented");
    }

    setPrice() {
        throw Error("Not Implemented");
    }
}

class MobileBG extends Reducer {
    setTitle() {
        this.title = this.dom.window.document.querySelector('.mmm').textContent;
    }

    setDescription() {
        this.desc = this.dom.window.document.querySelector('[colspan="4"]').innerHTML;
        this.desc = this.desc.trim();
    }

    setImage() {
        this.image = this.dom.window.document.querySelector('img').getAttribute('src');
        if (this.image.startsWith('//')) {
            this.image = this.image.substr(2);
        }
    }

    setLink() {
        this.link = this.dom.window.document.querySelector('.mmm').getAttribute('href');
        if (this.link.startsWith('//')) {
            this.link = this.link.substr(2);
        }
    }

    setPrice() {
        this.price = this.dom.window.document.querySelector('.price').innerHTML;
    }
}

module.exports = {
    MobileBG: MobileBG
}