function StoriesSlider(config) {
    this.storiesName = config.stories;
    this.storiesEl = document.querySelector(this.storiesName);
    this.slides = null;

    this.itemOffsetSide = config.itemOffsetSide || 0;
    this.itemLeftOffset =
        config.itemLeftOffset === "undefined"
            ? this.itemOffsetSide
            : config.itemLeftOffset;
    this.itemRightOffset =
        config.itemRightOffset === "undefined"
            ? this.itemOffsetSide
            : config.itemRightOffset;
    this.minDragDistance =
        config.minDragDistance === "undefined" ? 40 : config.minDragDistance;
    this.inertionCoef = config.inertionCoef || 0.92;

    this.useSelfController = config.useIsideController
        ? config.useIsideController
        : !isNaN(+config.useIsideController)
            ? config.useIsideController
            : null;
    this.dataAttributeName = config.dataAttrName
        ? config.dataAttrName
        : "data-sts";
    this.dataAttributeValue = config.dataAttrValue
        ? config.dataAttrValue
        : "stories-slider";

    this.slidesWrapper = null;
    this.childrenArray = null;

    this.referencePoint = 0;
    this.isDrag = false;
    this.offset = 0;
    this.offsetForAnimation = 0;
    this.tran = 0;
    this.pos = 0;
    this.diff = 0.05;

    this.diffBetweenstoriesAndSlidesWrapper = null;

    this.isClickPrevent = false;

    this.dir = 1; // -1 --- left, 1 --- right;

    this.leftPosition = 0;

    this.isBorder = false;

    this.isGateOpen = false;

    this.canInteract = true;

    this.setRAF = this.setRAF.bind(this);

    this.moveLeft = this.moveLeft.bind(this);

    this.moveRight = this.moveRight.bind(this);

    this._watcher = this.deb(this.watcher, this, 1000);

    this._updater = this.positionUpdaterForClick.bind(this);

    this._ls = function () {};
    this._rs = function () {};
    this._md = function () {};

    this.init();
}

StoriesSlider.prototype.getInteractPossibility = function () {
    return this.canInteract;
};

StoriesSlider.prototype.watcher = function () {
    this.setDiffBetweenstoriesAndSlidesWrapper();
};

StoriesSlider.prototype.positionUpdaterForClick = function (fn) {
    if (this.isGateOpen) {
        this.offset += this.dir * 5;
        fn.call(this);
    } else {
        return false;
    }
};

StoriesSlider.prototype.deb = function (fn, ctx, d) {
    var t = true;
    return function () {
        if (t) {
            t = false;
            setTimeout(function () {
                fn.call(ctx);
                t = true;
            }, d);
        } else {
            return false;
        }
    };
};

StoriesSlider.prototype.init = function () {
    this.childrenArray = this.leadToArray(this.getSlides());
    var wrap = this.createSlidesWrapper();
    var sizes = this.getFullSizesOfSliderLine(this.childrenArray);
    this.setSizesOnSlidesWrapper(sizes);
    this.setSlidesOnSlidesWrapper(wrap, this.childrenArray);
    this.setWrapperOnstories(this.slidesWrapper);
    this.setDiffBetweenstoriesAndSlidesWrapper();
    this.setRAF();
    if (this.useSelfController) {
        this.controller();
    }
};

StoriesSlider.prototype.getSlides = function () {
    return this.storiesEl.children;
};

StoriesSlider.prototype.isChildren = function () {
    return this.storiesEl.childNodes.length !== 0;
};

StoriesSlider.prototype.leadToArray = function (slides) {
    return Array.prototype.slice.call(slides);
};

StoriesSlider.prototype.getstoriesPaddings = function () {
    var _styles =
        this.storiesEl.currentStyle || window.getComputedStyle(this.storiesEl);
    return {
        pl: _styles["padding-left"],
        pt: _styles["padding-top"],
        pr: _styles["padding-right"],
        pb: _styles["padding-bottom"]
    };
};

StoriesSlider.prototype.getFullSizesOfSliderLine = function (slides) {
    var sizes = { w: 0, h: 0 };
    var pad = this.getstoriesPaddings();
    var _pl, _pr;
    for (var i = 0, len = slides.length; i < len; i++) {
        sizes.w += slides[i].offsetWidth;
        sizes.h = Math.max(sizes.h, slides[i].offsetHeight);
        var ml = null;
        var mr = null;
        if (i === 0) {
            _pl = parseInt(pad.pl, 10);
            ml = this.itemLeftOffset + _pl + "px";
            mr = this.itemOffsetSide + "px";
        } else if (i !== 0 && i !== len - 1) {
            ml = this.itemOffsetSide + "px";
            mr = this.itemOffsetSide + "px";
        } else {
            _pr = parseInt(pad.pr, 10);
            ml = this.itemOffsetSide + "px";
            mr = this.itemRightOffset + _pr + "px";
        }
        slides[i].style.marginLeft = ml;
        slides[i].style.marginRight = mr;
    }
    sizes.w += this.getSideOffsetCorrection(slides.length) + _pr + _pl;
    sizes.topMargin = parseInt(pad.pt, 10);
    sizes.bottomMargin = parseInt(pad.pb, 10);
    return sizes;
};

StoriesSlider.prototype.getSideOffsetCorrection = function (amount) {
    return (
        this.itemOffsetSide * 2 * (amount - 1) +
        this.itemLeftOffset +
        this.itemRightOffset
    );
};

StoriesSlider.prototype.createSlidesWrapper = function () {
    this.slidesWrapper = document.createElement("div");
    this.slidesWrapper.className = "sts-wrapper";
    this.slidesWrapper.setAttribute(
        this.dataAttributeName,
        this.dataAttributeValue
    );
    var self = this;
    return function (elements) {
        elements.forEach(function (el) {
            self.slidesWrapper.appendChild(el);
        });
    };
};

StoriesSlider.prototype.setSizesOnSlidesWrapper = function (sizes) {
    this.slidesWrapper.style.width = sizes.w + "px";
    this.slidesWrapper.style.height = sizes.h + "px";
    this.slidesWrapper.style.marginTop = sizes.topMargin + "px";
    this.slidesWrapper.style.marginBottom = sizes.bottomMargin + "px";
    this.storiesEl.style.height =
        sizes.h + sizes.topMargin + sizes.bottomMargin + "px";
};

StoriesSlider.prototype.setSlidesOnSlidesWrapper = function (
    wrapperSeter,
    slides
) {
    wrapperSeter(slides);
};

StoriesSlider.prototype.setWrapperOnstories = function (wrap) {
    this.storiesEl.appendChild(wrap);
};

StoriesSlider.prototype.setDiffBetweenstoriesAndSlidesWrapper = function () {
    this.diffBetweenstoriesAndSlidesWrapper =
        this.storiesEl.clientWidth - this.slidesWrapper.clientWidth;
};

StoriesSlider.prototype.checkBorder = function (fn) {
    if (this.isBorder) {
        return false;
    } else {
        fn.call(this);
        this.isBorder = true;
    }
};
StoriesSlider.prototype.getLeftPosition = function () {
    return (
        this.slidesWrapper.getBoundingClientRect().left -
        this.storiesEl.getBoundingClientRect().left
    );
};

StoriesSlider.prototype.setRAF = function () {
    this._watcher();

    this._updater(function () {
        this.offsetForAnimation =
            Math.abs(this.offset) <= this.minDragDistance
                ? this.offset
                : this.offset / 25;
        this.pos = this.tran + parseInt(this.offset.toFixed(3), 10);
    });

    this.leftPosition = this.getLeftPosition();

    this.dir = this.offset >= 0 ? 1 : -1;

    if (!this.isDrag && this.tran !== 0) {
        this.tran += this.offsetForAnimation *= this.inertionCoef;
        this.pos = this.tran;
    }

    if (this.leftPosition >= 0 && this.diffBetweenstoriesAndSlidesWrapper < 0) {
        if (!!this._ls) {
            this.isBorder = false;
        } else {
            this.isBorder = true;
        }
        this.checkBorder(function () {
            this._ls();
        });
    }

    if (this.leftPosition > 0 && this.dir > 0) {
        this.isBorder = false;
        this.isGateOpen = false;
        this.isDrag = false;
        this.tran = 0;
        this.pos = 0;
        this.offset = 0;
        this.offsetForAnimation = 0;
        this.checkBorder(function () {
            this._ls();
        });
    }
    if (
        this.diffBetweenstoriesAndSlidesWrapper >= this.leftPosition &&
        this.dir < 0
    ) {
        this.isBorder = false;
        this.isGateOpen = false;
        this.isDrag = false;
        this.tran = this.leftPosition;
        this.pos = this.leftPosition;
        this.offset = 0;
        this.offsetForAnimation = 0;
        this.checkBorder(function () {
            this._rs();
        });
    }
    if (
        this.diffBetweenstoriesAndSlidesWrapper < this.leftPosition &&
        this.leftPosition < 0
    ) {
        this.checkBorder(function () {
            this._md();
        });
    }
    this.movestories(this.pos);
    requestAnimationFrame(this.setRAF);
};

StoriesSlider.prototype.isLeftSide = function (callback) {
    this._ls = callback;
};

StoriesSlider.prototype.isRightSide = function (callback) {
    this._rs = callback;
};

StoriesSlider.prototype.isMedium = function (callback) {
    this._md = callback;
};

StoriesSlider.prototype.movestories = function (offset) {
    this.slidesWrapper.style.transform = "translate3d(" + offset + "px, 0, 0)";
};

StoriesSlider.prototype.getEvent = function (e) {
    return !!e.targetTouches ? e.targetTouches[0].clientX : e.clientX;
};

StoriesSlider.prototype.down = function (e) {
    if (this.isClickPrevent) {
        e.preventDefault();
        e.stopPropagation();
    }
    this.canInteract = true;
    this.isDrag = true;
    this.referencePoint = this.getEvent(e);
};

StoriesSlider.prototype.up = function (e) {
    this.isClickPrevent = false;
    //e.preventDefault();
    //e.stopPropagation();
    this.isDrag = false;
    this.tran = this.pos;
};

StoriesSlider.prototype.move = function (e) {
    this.isClickPrevent = true;
    e.preventDefault();
    e.stopPropagation();
    this.canInteract = false;
    this.isBorder = false;
    if (this.isDrag && !this.isGateOpen) {
        this.offset = this.getEvent(e) - this.referencePoint;
        this.offsetForAnimation =
            Math.abs(this.offset) <= this.minDragDistance
                ? this.offset
                : this.offset / 8;
        this.pos = this.tran + parseInt(this.offset.toFixed(3), 10);
    }
};

StoriesSlider.prototype.setSliderMotion = function (direction) {
    if (this.isGateOpen) {
        return false;
    }
    var self = this;
    this.offset = 0;
    this.isBorder = false;
    this.dir = direction;
    this.isGateOpen = true;
    this.isDrag = true;
    setTimeout(function () {
        self.isGateOpen = false;
        self.isDrag = false;
        self.tran = self.pos;
    }, 500);
};

StoriesSlider.prototype.moveLeft = function () {
    this.setSliderMotion(1);
};

StoriesSlider.prototype.moveRight = function () {
    this.setSliderMotion(-1);
};

StoriesSlider.prototype.controller = function (wrap) {
    var self = this;

    this.slidesWrapper.addEventListener("mousedown", function (e) {
        self.down(e);
    });

    this.slidesWrapper.addEventListener("mouseup", function (e) {
        self.up(e);
    });

    this.slidesWrapper.addEventListener("mousemove", function (e) {
        self.move(e);
    });

    this.slidesWrapper.addEventListener("mouseleave", function (e) {
        self.up(e);
    });
    /***************************************************************/
    this.slidesWrapper.addEventListener("touchstart", function (e) {
        self.down(e);
    });

    this.slidesWrapper.addEventListener("touchmove", function (e) {
        self.move(e);
    });

    this.slidesWrapper.addEventListener("touchend", function (e) {
        self.up(e);
    });
};

var slider = new StoriesSlider({
    stories: ".stories",
    itemLeftOffset: 5,
    itemRightOffset: 5,
    itemOffsetSide: 5,
    minDragDistance: 10,
    useIsideController: false,
    inertionCoef: 0.93
});

var el = $("[data-sts]");

el.on("mousedown touchstart", function (e) {
    slider.down(e);
});
el.on("mousemove touchmove", function (e) {
    slider.move(e);
});
el.on("mouseup", function (e) {
    slider.up(e);
});
el.on("mouseleave touchend", function (e) {
    slider.up(e);
});

function showButtons() {
    var prev = document.querySelector(".prev");
    var next = document.querySelector(".next");
    return function (type) {
        if (type === "left") {
            next.classList.add("nav-btn--active");
            prev.classList.remove("nav-btn--active");
        }
        if (type === "right") {
            next.classList.remove("nav-btn--active");
            prev.classList.add("nav-btn--active");
        }
        if (type === "medium") {
            next.classList.add("nav-btn--active");
            prev.classList.add("nav-btn--active");
        }
    };
}

var setActionsState = showButtons();

slider.isLeftSide(function () {
    setActionsState("left");
});

slider.isRightSide(function () {
    setActionsState("right");
});

slider.isMedium(function () {
    setActionsState("medium");
});

var prev = document.querySelector(".prev");
var next = document.querySelector(".next");

prev.addEventListener("click", function () {
    slider.moveLeft();
});

next.addEventListener("click", function () {
    slider.moveRight();
});
