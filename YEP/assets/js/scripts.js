

//
//	Init(s)
//


//Var(s)
let MoveSelectedYepWindowElement = null;
let ResizeSelectedYepWindow = null;
let MoveSelectedAirportDivisionResizerElement = null;
let lastMousePos_X, lastMousePos_Y;
let origWindowPos_X, origWindowPos_Y;
let currentYepWindowI = 0;
let openedAirportICAO = [];
let openedGenericOtherWindows = [];



//
//	Function(s)
//
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
// Create new window
function UserClickCreateNewAirport() {

    // Init(s)
    //
    let buttonElement = $('#spawnButton');
    let current_icao = $('#newAirportICAO').val().toUpperCase();

    // Vars(s)
    //


    // Test(s)
    let error = false;
    //

    //Action(s)
    if (!error) {

        UserConfirmCreateNewAirport(buttonElement, current_icao);
    }
    //Var(s)
}
function UserConfirmCreateNewAirport(buttonElement, current_icao) {

    // Init(s)
    //

    // Vars(s)
    //
    buttonElement.addClass('working');
    document.body.style.cursor = 'wait';


    // Test(s)
    //
    let error;
    if (current_icao.length != 4) {
        alert('ICAO Invalid.');

        error = true;
    }
    //
    if (yepSettings.general.doubleGuard && openedAirportICAO[current_icao]) {
        // Should find already opened airport and bring to front

        $('.yepWindow_MainDiv').each(function (i, v) {

            let thisElement = $(v);

            if (thisElement.attr('data-yepWindow-icao') == current_icao) {
                // Found the already opened airport window
                thisYepWindows_mainDiv = thisElement;

                thisYepWindows_mainDiv.css('left', '35px');
                thisYepWindows_mainDiv.css('top', '25px');


                yepSelectWindow(thisYepWindows_mainDiv);
                return false;
            }

        });

        error = true;
    }

    //Action(s)
    if (!error) {

        // Init(s)
        let newYepWindows_mainDiv = null;;
        let newYepWindows_mainContent = null;
        let newYepWindows_addBar_div = null;;
        //let airportWindows_iidsDiv;
        //let airportWindowsDivisionIidsResizer;

        // Main Window
        newYepWindows_mainDiv = createNewYepWindow('div', _, current_icao, () => { delete openedAirportICAO[current_icao]; });
        newYepWindows_mainDiv.attr('data-yepWindow-icao', current_icao);
        newYepWindows_mainDiv.attr('onClick', "");
        newYepWindows_mainContent = $(document.createElement('div'));
        newYepWindows_mainContent.addClass('newYepWindows_mainContent');

        // Title Bar
        newYepWindows_addBar_div = $(document.createElement('div'));
        newYepWindows_addBar_div.attr('title', 'Toggle Expand');
        newYepWindows_addBar_div.addClass('newYepWindows_addBar_div');
        newYepWindows_mainContent.append(newYepWindows_addBar_div);

        window.newYepWindows_divisionsToShow_arr = {
            //'iids': '//atm.navcanada.ca/gca/iwv/' + current_icao,
            'FlightAware': 'https://flightaware.com/live/airport/' + current_icao,
            'Weather': '//rt-2.net/YEP/Get/Weather/?icao=' + current_icao + '&noTitle&' + uncacheStr,
            'Weather': 'https://www.aviationweather.gov/metar/data?ids=' + current_icao + '&format=raw&hours=5&taf=on&layout=off',
            'Charts': 'http://rt2.czulfir.com/Charts/?dir=' + current_icao,
            'Notams': 'http://rt2.czulfir.com/Notams/?icao=' + current_icao,
        };


        console.log(newYepWindows_divisionsToShow_arr);
        console.log(Object.keys(newYepWindows_divisionsToShow_arr));
        $(Object.keys(newYepWindows_divisionsToShow_arr)).each( (i, index) => {
            console.log(index);
            console.log(newYepWindows_divisionsToShow_arr);
            console.log(window.newYepWindows_divisionsToShow_arr[index]);


            let this_sectionDiv = null;
            let this_SectionResizer = null;
            let sectionName = index;
            let sectionUrl = '//rt-2.net/YEP/Get/url.php?t=' + Date.now() + '&url=' + encodeURIComponent(window.newYepWindows_divisionsToShow_arr[index]);
            let sectionClasses = ' '+current_icao+' airportWindows_' + sectionName + 'Division airportWindowsDivision';
            let sectionIframeClasses = ' airportWindowsIframes airportWindowsIframe_' + sectionName;
            let sectionResizerClasses = ' airportWindows_' + sectionName + 'Resizer airportWindowsDivisionResizer';

            this_sectionDiv = $(document.createElement('div'));
            this_sectionDiv.addClass(sectionClasses);
            //airportWindows_weatherDiv.text('FlightAware');
            this_sectionIframe = $(document.createElement('iframe'));
            this_sectionIframe.addClass(sectionIframeClasses);
            //this_sectionIframe.attr('referrerpolicy', 'no-referrer-when-downgrade');
            this_sectionIframe.attr('referrerpolicy', 'no-referrer');
            this_sectionIframe.attr('src', sectionUrl);
            this_sectionDiv.append(this_sectionIframe);
            newYepWindows_mainContent.append(this_sectionDiv);
            this_sectionDiv.width(yepModifiedSettings.yepWindowDivision_defaultHeight);
            this_sectionDiv.height(yepModifiedSettings.yepWindowDivision_defaultHeight);

            // Resizer
            this_SectionResizer = $(document.createElement('div'));
            this_SectionResizer.addClass(sectionResizerClasses);
            this_SectionResizer.append($(document.createElement('hr')));
            newYepWindows_mainContent.append(this_SectionResizer);

            this_sectionDiv_toggleButton = $(document.createElement('button'));
            this_sectionDiv_toggleButton.text(sectionName);
            this_sectionDiv_toggleButton.attr('onClick', '$(\'' + sectionClasses.replaceAll(' ', '.') + '\').slideToggle()');
            this_sectionDiv_toggleButton.addClass('newYepWindows_addBar_div_buttons');
            newYepWindows_addBar_div.append(this_sectionDiv_toggleButton);

            // Callback(s)
            this_SectionResizer.mousedown((e) => {
                yepWindowResizeMouseDown(e, this_sectionDiv);
            });

        });
        /*
        // IIS Division
        airportWindows_iidsDiv = $(document.createElement('div'));
        airportWindows_iidsDiv.addClass('airportWindows_iidsDivision airportWindowsDivision');
        //airportWindows_iidsDiv.text('FlightAware: ');
        let airportWindows_iidsIframe = $(document.createElement('iframe'));
        airportWindows_iidsIframe.addClass('airportWindowsIframes');
        airportWindows_iidsIframe.attr('referrerpolicy', 'no-referrer');
        airportWindows_iidsIframe.attr('src', '//atm.navcanada.ca/gca/iwv/' + current_icao);
        airportWindows_iidsDiv.append(airportWindows_iidsIframe);
        newYepWindows_mainContent.append(airportWindows_iidsDiv);
        airportWindows_iidsDiv_ToggleButton = $(document.createElement('button'));
        airportWindows_iidsDiv_ToggleButton.attr('rel', 'Toggle Expand');
        airportWindows_iidsDiv_ToggleButton.text('IIDS');
        airportWindows_iidsDiv_ToggleButton.attr('onClick', '$(\'.airportWindows_iidsDivision.airportWindowsDivision\').toggle()');
        airportWindows_iidsDiv_ToggleButton.addClass('newYepWindows_addBar_div_buttons');
        newYepWindows_addBar_div.append(airportWindows_iidsDiv_ToggleButton);

        // Resizer
        airportWindowsDivisionIidsResizer = $(document.createElement('div'));
        airportWindowsDivisionIidsResizer.addClass('airportWindowsDivisionResizer');
        airportWindowsDivisionIidsResizer.append($(document.createElement('hr')));
        newYepWindows_mainContent.append(airportWindowsDivisionIidsResizer);

        // Weather Division
        airportWindows_weatherDiv = $(document.createElement('div'));
        airportWindows_weatherDiv.addClass('airportWindows_weatherDivision airportWindowsDivision');
        //airportWindows_weatherDiv.text('FlightAware');
        airportWindows_weatherIframe = $(document.createElement('iframe'));
        airportWindows_weatherIframe.addClass('airportWindowsIframes');
        airportWindows_weatherIframe.attr('src', 'kk');
        airportWindows_weatherDiv.append(airportWindows_weatherIframe);
        newYepWindows_mainContent.append(airportWindows_weatherDiv);

        // Resizer
        airportWindowsDivisionWeatherResizer = $(document.createElement('div'));
        airportWindowsDivisionWeatherResizer.addClass('airportWindowsDivisionResizer');
        airportWindowsDivisionWeatherResizer.append($(document.createElement('hr')));
        newYepWindows_mainContent.append(airportWindowsDivisionWeatherResizer);
        

        // Callback(s)
        airportWindowsDivisionIidsResizer.mousedown(function (e) {
            yepWindowResizeMouseDown(e, airportWindows_iidsDiv);
        });
        airportWindowsDivisionWeatherResizer.mousedown(function (e) {
            yepWindowResizeMouseDown(e, airportWindows_weatherDiv);
        });
        */

        // Var(s)
        newYepWindows_mainDiv.append(newYepWindows_mainContent);
        yepSelectWindow(newYepWindows_mainDiv);
        openedAirportICAO[current_icao] = true;

    }
    //Var(s)
    document.body.style.cursor = 'default';
    buttonElement.removeClass('working');
}

function UserClickGenericTopLinkButton(buttonElement) {

    // Init(s)
    //
    buttonElement.addClass('working');
    document.body.style.cursor = 'wait';

    // Vars(s)
    //
    let href = buttonElement.attr('data-yepWindow-a-href');
    let task = buttonElement.attr('data-yepWindow-a-task');
    let title = buttonElement.attr('data-yepWindow-a-title');

    //Action(s)
    createGenericIframeYepWindow(_, title, task, href);


    //Var(s)
    document.body.style.cursor = 'default';
    buttonElement.removeClass('working');
}
function UserRightClickGenericTopLinkButton(buttonElement) {

    // Init(s)
    //
    buttonElement.addClass('working');
    document.body.style.cursor = 'wait';

    // Vars(s)
    //
    let href = buttonElement.attr('data-yepWindow-a-href');
    let task = buttonElement.attr('data-yepWindow-a-task');
    window.open(href, '_blank' + task);

    //Var(s)
    document.body.style.cursor = 'default';
    buttonElement.removeClass('working');
}

function createGenericIframeYepWindow(classes, title, task, href, onCloseFunction) {

    // Init(s)
    //

    // Vars(s)
    //
    let cached_onCloseFunction = onCloseFunction;
    onCloseFunction = function () {
        delete openedGenericOtherWindows[task];
        if (cached_onCloseFunction) cached_onCloseFunction();
    };
    // Test(s)
    //
    let error;
    //
    if (yepSettings.general.doubleGuard && openedGenericOtherWindows[task]) {
        // Should find already opened airport and bring to front

        $('.yepWindow_MainDiv').each(function (i, v) {

            let thisElement = $(v);
            if (thisElement.attr('data-yepWindow-otherTask') == task) {
                // Found the already opened airport window

                thisElement.css('left', '35px');
                thisElement.css('top', '25px');
                yepSelectWindow(thisElement);

                return false;
            }

        });

        error = true;
    }

    //Action(s)
    if (!error) {

        let newYepWindows_mainDiv = createFullIframeYepWindow(classes, title, task, href, onCloseFunction);

        openedGenericOtherWindows[task] = true;

        yepSelectWindow(newYepWindows_mainDiv);
    }
    //Var(s)
}

function createFullIframeYepWindow(classes, title, task, href, onCloseFunction) {

    let newYepWindows_mainDiv = createNewYepWindow('div', classes + ' ' + task, title, onCloseFunction);
    newYepWindows_mainDiv.attr('data-yepWindow-otherTask', task);

    let newYepWindows_mainContent = $(document.createElement('div'));
    newYepWindows_mainContent.addClass('newYepWindows_mainContent');


    let newWindows_Iframe = $(document.createElement('iframe'));
    newWindows_Iframe.addClass('WindowsIframesAlone');
    newWindows_Iframe.attr('referrerpolicy', 'no-referrer');
    newWindows_Iframe.attr('sandbox', 'allow-same-origin allow-scripts allow-popups allow-forms');
    //newWindows_Iframe.attr('onLoad', 'console.log($(this)[0].contentWindow.find(\'body\'));');
    newWindows_Iframe.attr('src', href + ((href.indexOf('?') == -1) ? '?' : '&') + uncacheStr);
    newYepWindows_mainContent.append(newWindows_Iframe);

    newYepWindows_mainDiv.append(newYepWindows_mainContent);

    return newYepWindows_mainDiv;

}

// Save Session
function UserClickSaveButton() {

    // Init(s)
    //

    // Vars(s)
    //


    // Test(s)
    //
    let error = false;

    //Action(s)
    if (!error) {

        let dataUrlString = 'data:text/plain;charset=UTF-8,' + JSON.stringify($('#playground'));
        var newTempLink = document.createElement('a');
        newTempLink.href = dataUrlString;
        newTempLink.download = "file.yep";
        newTempLink.click();
    }

    //Var(s)

}

// Start moving window
function yepWindowMoveMouseDown(e, mainDivElement) {

    // Init(s)
    //
    let currentElement;

    // Vars(s)
    //
    currentElement = mainDivElement;

    //Action(s)
    //
    lastMousePos_X = e.clientX;
    lastMousePos_Y = e.clientY;
    origWindowPos_X = currentElement.position().left;
    origWindowPos_Y = currentElement.position().top;

    //Var(s)
    //
    MoveSelectedYepWindowElement = mainDivElement;
    $('#mouseDragAntiSelectDiv').show();

}

// Start resizing window
function yepWindowResizeMouseDown(e, mainDivElement) {

    // Init(s)
    //
    let last_sibling_element;

    // Vars(s)
    //


    // Test(s)
    //
    /*
    console.log(ResizeSelectedYepWindow);
    console.log(ResizeSelectedYepWindow.siblings().last());
    console.log(last_sibling_element);
    console.log('height: ' + last_sibling_element.height());
    console.log('offsetTop: ' + last_sibling_element.offset().top);
    console.log('total: : ' + (last_sibling_element.height() + last_sibling_element.offset().top));
    console.log('Parent Height: ' + last_sibling_element.parent().height() );
    console.log('Parent Total Height: ' + (last_sibling_element.parent().height() + last_sibling_element.parent().offset().top));

    last_sibling_element = ResizeSelectedYepWindow.siblings().last();
    */
    ResizeSelectedYepWindow = mainDivElement;
    //Action(s)
    //
    yepWindowResizeOrMoveStartDragging(e, mainDivElement);

}

// Start window section
function yepWindowResizeOrMoveStartDragging(e, mainDivElement) {

    // Init(s)
    //
    let currentElement;

    // Vars(s)
    //
    currentElement = mainDivElement;

    //Action(s)
    //
    lastMousePos_X = e.clientX;
    lastMousePos_Y = e.clientY;
    origWindowPos_X = mainDivElement.width();
    origWindowPos_Y = mainDivElement.height();

    //Var(s)
    //
    ResizeSelectedYepWindow = mainDivElement;
    $('#mouseDragAntiSelectDiv').show();
}

// Stop moving/resizing
function yepWindowMainDivMouseUp() {

    // Init(s)
    //

    // Vars(s)
    //
    MoveSelectedYepWindowElement = null;
    ResizeSelectedYepWindow = null;

    //Action(s)
    //
    $('#mouseDragAntiSelectDiv').hide();

}

// Move/resizing windows
function yepWindowMainDivMouseMoved(e) {
    if (MoveSelectedYepWindowElement != null) {

        // Init(s)
        //
        let currentElement;
        let playgroundDivElement;
        let mouseDiffX, mouseDiffY, mouseDiffYY;
        let result_X, result_Y;
        let currentWidth;
        let maxExcessX;
        let min_X, max_X;

        let currentHeight;
        let maxExcessY;
        let min_Y, max_Y;


        // Move
        //vars
        currentElement = MoveSelectedYepWindowElement;
        playgroundDivElement = $('#playground');
        mouseDiffX = lastMousePos_X - e.pageX;
        mouseDiffY = lastMousePos_Y - e.pageY;
        result_X = origWindowPos_X - mouseDiffX;
        result_Y = origWindowPos_Y - mouseDiffY;
        currentWidth = currentElement.width();
        maxExcessX = currentWidth / 3;
        min_X = -maxExcessX;
        max_X = playgroundDivElement.width() - (currentWidth - maxExcessX);

        currentHeight = currentElement.height();
        maxExcessY = currentHeight * 0.7;
        min_Y = 0;
        max_Y = playgroundDivElement.height() - (currentHeight - maxExcessY);


        if (result_X > max_X) result_X = max_X;
        if (result_X < min_X) result_X = min_X;
        if (result_Y > max_Y) result_Y = max_Y;
        if (result_Y < min_Y) result_Y = min_Y;
        //actions
        currentElement.css('left', result_X + 'px');
        currentElement.css('top', result_Y + 'px');
    }
    if (ResizeSelectedYepWindow != null) {
        // Resize window
        currentElement = ResizeSelectedYepWindow;
        mouseDiffX = lastMousePos_X - e.pageX;
        mouseDiffY = lastMousePos_Y - e.pageY;
        currentElement.css('width', (origWindowPos_X - mouseDiffX) + 'px');
        currentElement.css('height', (origWindowPos_Y - mouseDiffY) + 'px');
    }
}

// Create window
function createNewYepWindow(tag, classes, barTitle, onCloseFunction, visible) {


    // Init(s)
    //
    let current_id;
    let newYepWindows_mainDiv_id;
    let newYepWindows_mainDiv;
    let newYepWindows_topBar;
    let newYepWindows_topBar_id;
    let newYepWindows_topBar_title;
    let newYepWindows_topBar_close;
    let newYepWindows_topBar_expand;
    let newYepWindows_resizeCorner;

    // Vars(s)
    //
    current_id = currentYepWindowI++;
    newYepWindows_mainDiv_id = 'yepWindow_MainDiv_' + current_id;
    classes = (typeof classes !== 'undefined') ? classes : '';
    visible = (typeof visible !== 'undefined') ? visible : true;


    // Test(s)
    //

    //Action(s)
    //
    //console.log(yepModifiedSettings);
    newYepWindows_mainDiv = $(document.createElement(tag));
    newYepWindows_mainDiv.attr('id', newYepWindows_mainDiv_id);
    newYepWindows_mainDiv.addClass('yepWindow_MainDiv');
    if (classes.length > 0) newYepWindows_mainDiv.addClass(classes);

    newYepWindows_mainDiv.css('z-index', (visible) ? 200 : -1);
    newYepWindows_topBar = $(document.createElement('div'));
    newYepWindows_topBar.addClass('yepWindow_topBar');
    newYepWindows_topBar_id = $(document.createElement('span'));
    newYepWindows_topBar_id.addClass('yepWindow_topBar_id');
    if (current_id) newYepWindows_topBar_id.text(current_id);
    newYepWindows_topBar_title = $(document.createElement('span'));
    newYepWindows_topBar_title.addClass('yepWindow_topBar_title');
    if (barTitle.length > 0) newYepWindows_topBar_title.text(barTitle);
    newYepWindows_topBar_close = $(document.createElement('span'));
    newYepWindows_topBar_close.attr('title', 'Close Window');
    newYepWindows_topBar_close.addClass('yepWindow_topBar_close');
    newYepWindows_topBar_close.text('X');
    newYepWindows_topBar_expand = $(document.createElement('span'));
    newYepWindows_topBar_expand.attr('title', 'Toggle Expand');
    newYepWindows_topBar_expand.addClass('yepWindow_topBar_expand');
    newYepWindows_topBar_expand.html("□");
    newYepWindows_resizeCorner = $(document.createElement('div'));
    newYepWindows_resizeCorner.addClass('yepWindow_resizeCorner');

    newYepWindows_topBar.append(newYepWindows_topBar_id);
    newYepWindows_topBar.append(newYepWindows_topBar_title);
    newYepWindows_topBar.append(newYepWindows_topBar_close);
    newYepWindows_mainDiv.append(newYepWindows_topBar);
    newYepWindows_mainDiv.append(newYepWindows_resizeCorner);

    $('#playground').append(newYepWindows_mainDiv);

    newYepWindows_mainDiv.width(window.yepModifiedSettings.yepWindow_defaultWidth);
    newYepWindows_mainDiv.height(window.yepModifiedSettings.yepWindow_defaultHeight);

    //console.log('WTF');
    //console.log(newYepWindows_mainDiv);
    //console.log(window.yepModifiedSettings.yepWindow_defaultWidth);

    //Var(s)
    //
    newYepWindows_mainDiv.mousedown(function (e) {
        yepSelectWindow(newYepWindows_mainDiv);
    });
    newYepWindows_topBar_title.mousedown(function (e) {
        yepWindowMoveMouseDown(e, newYepWindows_mainDiv);
    });
    newYepWindows_resizeCorner.mousedown(function (e) {
        yepWindowResizeMouseDown(e, newYepWindows_mainDiv);
    });
    newYepWindows_topBar_expand.click(function (e) {
    });
    newYepWindows_topBar_close.click(function (e) {
        if (onCloseFunction) onCloseFunction();
        if (visible) {
            newYepWindows_mainDiv.remove();
        }
        else {
            newYepWindows_mainDiv.css('z-index', -1);
        }
    });

    return newYepWindows_mainDiv;
}

// Update windows z-index
function yepSelectWindow(windowElement) {
    $('.yepWindow_MainDiv').each(function (i, v) {
        let thisElement = $(v);
        thisElement.css('z-index', thisElement.css('z-index') - 1);
    });
    $('.selected').each(function (i, v) {
        let thisElement = $(v);
        thisElement.removeClass('selected');
    });
    windowElement.css('z-index', 200);
    windowElement.addClass('selected');
}

//
//	Callback(s)
//
$(document).ready(function () {

    // Var(s)
    let playgroundDivElement = $('#playground');

    // User exit the screen
    $(document).mouseout(function (e) {

        if (MoveSelectedYepWindowElement != null) {
            e = e ? e : window.event;
            let from = e.relatedTarget || e.toElement;
            if (!from || from.nodeName == "HTML") {
                // stop your drag event here
                // for now we can just use an alert
                yepWindowMainDivMouseUp(e);
            }
        }

    });

    //
    $(document).mousemove(function (e) {

        yepWindowMainDivMouseMoved(e);

    });

    //
    $(document).mouseup(function (e) {

        yepWindowMainDivMouseUp(e);

    });


    // User presed ENTER to add new airport
    $('#newAirportICAO').keyup(function (e) {
        if (e.keyCode == 13) {

            UserClickCreateNewAirport(e);

        }
    });

    // Open Voice Monitor
    $('.genericTopLinkButton').click(function (e) {

        UserClickGenericTopLinkButton($(e.currentTarget));

    });
    $('.genericTopLinkButton').contextmenu(function (e) {
        e.preventDefault();
        UserRightClickGenericTopLinkButton($(e.currentTarget));
    });
    // Save session
    $('#saveButton').click(function (e) {

        UserClickSaveButton(e);

    });
    // User clicked to add new airport
    $('#spawnButtonClickableSpan').click(function (e) {

        UserClickCreateNewAirport(e);

    }).mouseenter(function () {
        $('#spawnButton').addClass('mouseInClickableArea');
    }).mouseleave(function () {
        $('#spawnButton').removeClass('mouseInClickableArea');
    });

    // At the end, call 'yepReady'
    setTimeout(function () {
        $(document).trigger('yepReady');
    }, 1);
});

function exampelFunction() {


    // Init(s)
    //

    // Vars(s)
    //


    // Test(s)
    //

    //Action(s)
    //

    //Var(s)
    //
}