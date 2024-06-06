<template>
	<input type="text" 
		ref="flatpickr" 
		class="form-control flatpickr flatpickr-input bg-white" 
		:value="value" 
		@input="update($event.target.value)" 
		autocomplete="off">
</template>

<script>
	import flatpickr from "flatpickr"
	export default {
        props: {
        	value: String,
        	filedValue: String,
        	noCalendar: {
        		default: false
        	},
        	dateTime: {
        		default: false
        	},
        	step: {
        		default: 5
        	},
        	format: {
				type: String,
        		default: 'Y-m-d'
        	},
        	timeFormat: {
				type: String,
        		default: 'H:i'
        	},
        	minDate: {
        		default: ''
        	},
        	maxDate: {
        		default: null
        	},
            config: {
                type: Object,
                default() {
                    return {}
                },
            },
        },

        mounted() {
			flatpickr(this.$refs.flatpickr, this.defaultConfig)
        },

        watch: {
			minDate(val, oldVal) {
				if(val > this.value) {
					this.update('')
				}
			}
        },

        computed: {
			defaultConfig() {
				const self = this
				let initConfig = {};
				if(!self.noCalendar) {
					initConfig = {
						...self.config,
						enableTime: self.dateTime,
						dateFormat: (self.dateTime) ? `${self.format} ${this.timeFormat}` : self.format,
						minDate: self.minDate,
						maxDate: self.maxDate,
						onOpen: [
					        function(selectedDates, dateStr, instance){
					            instance.set('minDate', self.minDate)
					            instance.set('maxDate', self.maxDate)
					        }
						],
						onChange: function(selectedDates, dateStr, instance) {
							if(dateStr) {
								self.$emit('change-datepicker', dateStr)
							}
						},
					};
				} else if(self.noCalendar) { // if only time picker need
					initConfig = {
						...this.config,
						enableTime: self.noCalendar,
						noCalendar: true,
    					dateFormat: this.timeFormat,
					};
				}

				if(self.dateTime || self.noCalendar)
					initConfig['minuteIncrement'] = self.step

				return initConfig
			}
        },

	    methods: {
	        update (v){
	            this.$emit('input', v)
	        }
	    },
    }
</script>
