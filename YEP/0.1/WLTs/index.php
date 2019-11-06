<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>WLTs (Waiting List Timers)</title>
	
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			font-family: "Courier New", monospace;
			background-color: rgb(195, 195, 195);
		}

		#debugSpan {
			font-size: 10px;
			position: fixed;
			bottom: 3px;
		}

		.aircraftLi {
			white-space: nowrap;
			/*background-color: black;
			height: fit-content;*/
		}

		.NameLabel {
			font-weight: bold;
		}

		.AircraftLabel {
			padding: 2px 2px;
			margin: 0px 3px;
			font-family: "Courier New", monospace;
			color: white;
			background-color: black;
			text-transform: uppercase;
		}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<script>
		// Constants
		window.last_reminder_playing = 0;
		window.REMINDER_VOLUME = 0.5;
		window.REMINDER_INTERVAL_SEC = 60;
		window.REMINDER_LENGTH_MS = 750;


		/* Function(s) */
		function _PlayReminderSound() {

			if (Date.now() - last_reminder_playing > (REMINDER_LENGTH_MS + 150)) {
				let audioElement = $('#reminder_audio')[0];

				audioElement.volume = REMINDER_VOLUME;
				audioElement.play();

				last_reminder_playing = Date.now();

				setTimeout(() => {
					audioElement.pause();
					audioElement.currentTime = 0;
				}, REMINDER_LENGTH_MS);
			}
		}


		/* Classe(s) */
		//
		class Aircraft {

			constructor(name) {

				this.secondInterval = null;
				this.state = 0;
				this.name = name;
				this.uniqueId = Date.now();
				this.createdTime = Date.now();
				this.assignedTime = Date.now() + (2 * REMINDER_INTERVAL_SEC * 1000);
				this.liElement = null;
				this.liChildElements = {};

				function _createElement(type, elClass, elHtml, elContextMenuAction) {

					let newElement = $(`<${type}>`);
					$(newElement).addClass(elClass);
					$(newElement).html(elHtml);
					if (elContextMenuAction) $(newElement).contextmenu(elContextMenuAction);

					return newElement;
				}

				function _createLabel(elClass, elHtml, elContextMenuAction) {

					let newLabelElement = _createElement('span', elClass, elHtml, elContextMenuAction);
					$(newLabelElement).addClass('AircraftLabel');

					return newLabelElement;
				}

				this.liElement = _createElement('li', 'aircraftLi', '');
				$(this.liElement).on('click', (e) => {
					if (confirm('Delete "' + name + '"?')) {

						this.destroy();
					}
				});
				$('#aircraftList').append(this.liElement);

				this.liChildElements.timeLabel = _createLabel('TimeLabel', '0000:00', () => {
					this._RightClickTimeLabel();
					return false;
				});
				this.liElement.append(this.liChildElements.timeLabel);

				this.liChildElements.nameLabel = _createLabel('NameLabel', this.name, () => {
					this._RightClickNameLabel();
					return false;
				});
				this.liElement.append(this.liChildElements.nameLabel);

				this.liChildElements.originalTimeLabel = _createLabel('OriginalTimeLabel', '0000:00');
				this.liElement.append(this.liChildElements.originalTimeLabel);

				/* Timer(s) */
				this.secondInterval = setInterval(() => {
					this._updateTimeLabels()
				}, 1000);

				this._updateAircraftLiColor();

			}
			destroy() {
				//

				this.liElement.remove();
				clearInterval(this.secondInterval);
			}

			_updateAircraftLiColor() {

				const state = this.state;

				const aircraftLiElement = this.liElement;

				let color = 'gray';
				let fontWeight = 'normal';

				if (Date.now() - this.assignedTime >= 0) {
					switch (state) {
						case 0:
							color = 'white';
							break;
						case 1:
							color = 'green';
							break;
						case 2:
							color = 'yellow';
							break;
						case 3:
							color = 'orange';
							fontWeight = 'bold';
							break;
						default:
							color = 'red';
							fontWeight = 'bold';
							break;
						
					}
				}

				$.each([
					this.liChildElements.originalTimeLabel,
					this.liChildElements.nameLabel,
					this.liChildElements.timeLabel,
				], function() {

					$(this).css('color', color);
					$(this).css('font-weight', fontWeight);
				});

			}

			/* Private Function(s) */
			_RightClickNameLabel() {


				let nameString = prompt('Change Name :');

				if (confirm(`Are you sure you want to change "${this.name}" to "nameString"?`)) {

					this.name = nameString;

					$(this.liChildElements.nameLabel).html(this.name);

				}
			}

			_RightClickTimeLabel() {

				let inputValue = prompt('New time :');

				if (inputValue == '-0') {

					this.assignedTime = parseInt(Date.now());
					this.state = 0;
					this._updateAircraftLiColor();
				}


				let ms = parseInt((parseFloat(inputValue) * REMINDER_INTERVAL_SEC * 1000));

				if (ms < 0) {

					this.state = 0;
					this.assignedTime = parseInt(Date.now() - ms);

					this._updateAircraftLiColor();

				}

			}

			_updateTimeLabels() {

				function _updateTimeLabelFromSecondLeft(element, secondLeft) {

					const thisMinute = parseInt(Math.abs(secondLeft / 60));
					const thisSecond = parseInt(Math.abs(secondLeft % 60));

					let minuteString = (secondLeft < 0) ? '-' + ('000' + thisMinute).slice(-3) : ('000' + thisMinute).slice(-4);
					let secondString = ('0' + thisSecond).slice(-2);

					$(element).html(minuteString + ':' + secondString);

				}

				let assignedTime = this.assignedTime;
				let createdTime = this.createdTime;
				let assignedTimeLabel = this.liChildElements.timeLabel;
				let createdTimeLabel = this.liChildElements.originalTimeLabel;
				let liElement = this.liElement;
				let diff = parseInt((Date.now() - assignedTime) / 1000);

				if (diff % REMINDER_INTERVAL_SEC == 0) {

					if (diff > 0) {
					
						this.state++;
						
						if (this.state > 0) {
							// Reminder must be send

							_PlayReminderSound();
						}

					}
					
					this._updateAircraftLiColor();
				}

				const assigned_secondLeft = diff;
				const created_secondLeft = parseInt((Date.now() - createdTime) / 1000);

				_updateTimeLabelFromSecondLeft(assignedTimeLabel, assigned_secondLeft);
				_updateTimeLabelFromSecondLeft(createdTimeLabel, created_secondLeft);
			}

		}


		$(document).ready(function() {

			// Debug span
			$('#debugSpan').html(`Values: volume:${REMINDER_VOLUME} | reminderIntervalSec:${REMINDER_INTERVAL_SEC} | ReminderLengthMs:${REMINDER_LENGTH_MS}`);

			// Document ready
			$('#newAircraftInput').bind('keypress', function(e) {
				if (e.keyCode == 13) {
					console.log($(this).val());
					new Aircraft($(this).val());
					$(this).val('');
				}
			});
		});

	</script>

</head>

	<body>
		<span id="debugSpan"></span>

		<h3>
			Waiting aircrafts
		</h3>
		<div>
			Add: <input id="newAircraftInput" type="text" />
		</div>


		<ol id="aircraftList">

		</ol>
		<div id="audioContainer" style="display:none">

		</div>

		<audio id="reminder_audio" src="http://soundbible.com/grab.php?id=2197&type=mp3" />

	</body>

</html>