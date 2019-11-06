//
//	Init(s)
//
//Var(s)
window.yepSettings = {};
window.yepModifiedSettings = {};
yepSettings.general = {};
yepSettings.general = {};
yepSettings.general.doubleGuard = true;
yepSettings.general.yepWindow_backgroundOpacityActive = 0.9;
yepSettings.general.yepWindow_backgroundOpacityInactive = 0.5;
yepSettings.general.yepWindow_airportDividerHeight = '4px';
yepSettings.general.yepWindow_resizeCornerSize = '12px';
let yepSettingsCleanNames = {
    'doubleGuard': 'Prevent opening duplicates',

}
let yepSettingsDiv;
//
//	Function(s)
//
function initYepSettingWindow() {
    yepSettingsDiv = createNewYepWindow('div', _, 'Settings', () => {

        $('#settingsButton').prop('disabled', false);
    }, false);
    yepSettingsTmpContainerDiv = $(document.createElement('div'));
    $.map(yepSettings.general, function (v, i) {
        let cleanName = (yepSettingsCleanNames[i]) ? yepSettingsCleanNames[i] : i;
        let thisSetting = $(document.createElement('div'));
        thisSetting.addClass('settingDiv');
        let editHTML = '';
        switch (typeof v) {
            case "string":
            case "number":
                editHTML = '<input class="value" onChange="yepModifiedSettings.' + i + ' = $(this).val(); less.modifyVars(yepModifiedSettings);" value="' + v + '"/>';
                break;
            case "boolean":
                editHTML = (v) ?
                    '<select><option value="0">false</option><option value="1" selected>true</option></select>':
                    '<select><option value="0">false</option><option value="1" selected>true</option></select>';
                break;
            default:
                editHTML = '<span class="value">' + v + '</span>';
        }
        thisSetting.html('<span class="name">' + cleanName + '</span>: ' + editHTML);
        //thisSetting.find('<span class="name">' + cleanName + '</span>: ' + editHTML);
        //let thisSetting_Name = $(document.createElement('span'));
        //let thisSetting_Value = $(document.createElement('span'));
        //let thisSetting_mainDiv = $(document.createElement('div'));
        yepSettingsTmpContainerDiv.append(thisSetting);

    });
    yepSettingsDiv.append(yepSettingsTmpContainerDiv);

}

//
//	Callback(s)
//
$(document).bind('yepReady', function () {

    // Var(s)

    // Callback(s)
    $('#settingsButton').click(function (e) {
        let thisElement = $(this);
        thisElement.prop('disabled', true);
        yepSelectWindow(yepSettingsDiv);

    });

    // Init(s)
    initYepSettingWindow();
});
