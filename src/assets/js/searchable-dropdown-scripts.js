function findMe(name)
{
    var myEl = $('[x-ref="' + name + '"]')[0];
    var myX = myEl ? myEl.__x : undefined;
    return myX ? myX.$data : undefined;
}

(function () {
    var mergeConfig = function (oldConfig, newConfig) {
        oldConfig.data = newConfig.data;    
        oldConfig.emptyOptionsMessage = newConfig.emptyOptionsMessage;
        oldConfig.name = newConfig.name; 
        oldConfig.placeholder = newConfig.placeholder;
        oldConfig.multiselect = newConfig.multiselect;
        oldConfig.entangle = newConfig.entangle;
        oldConfig.context = newConfig.context;
        oldConfig.whoami = newConfig.whoami;
        oldConfig.value = newConfig.multiselect ? (newConfig.value ?? []) : newConfig.value;
        return oldConfig;
    };

    var dataTemplate = function() {
        return {
            data: {},
            emptyOptionsMessage: '',
            name: '',
            open: false,
            selectAll: false,
            onlySelected: false,
            options: [],
            placeholder: '',
            search: '',
            multiselect: false,
            entangle: '',
            context: '',
            whoami: '',
            setup:false,
            value: null,

            closeListbox() {
                this.open = false;
                this.search = '';
            },

            init() {

                me = this;
                this.setup = true;
                this.options = this.data;

                if (this.multiselect) {
                    this.value = this.options.filter(item => me.value.includes(item.key));
                } else {
                    if (!this.options.filter(item => me.value == item.key)) this.value = null;
                }

                this.$watch('search', ((value) => {
                    me.options = me.data.filter((item) => item.value.toLowerCase().includes(value.toLowerCase()))
                }))

                if (this.context && this.entangle) {
                    var livewireParent = window.livewire.find(this.context);
                    this.$watch('value', (updateValue) => {
                        livewireParent.set(this.entangle, updateValue);
                    });
                }

            },

            selectOption(selectedValue) {
                if (!this.open) return this.toggleListboxVisibility();

                if (!this.multiselect) {
                    if (this.value && selectedValue === this.value) {
                        this.value = null;
                    } else {
                        this.value = selectedValue;
                    }
                    this.closeListbox();
                } else {
                    if (this.value.includes(selectedValue)) {
                        this.value.splice(this.value.indexOf(selectedValue), 1);
                    } else {
                        this.value.push(selectedValue);
                    }
                    if (this.onlySelected) {
                        this.showOnlySelectedOptionsInList();
                    }
                    if (this.value.length != this.data.length && this.selectAll) {
                        this.selectAll = false;
                    }
                }
            },

            shouldShowDisplaySelectedOptions() {
                return this.multiselect && this.value.length && this.value.length != this.data.length;
            },

            showSelectedOptions: function () {
                if (this.value.length === 0) return this.placeholder;
                return this.value.map(value => this.options[value]).join(',');
            },

            showOnlySelectedOptionsInList() {
                this.search = '';
                if (!this.value.length) {
                    this.onlySelected = false;
                }
                if (this.onlySelected) {
                    this.options = this.data.filter(item => this.value.includes(item.key))
                } else {
                    this.options = this.data;
                }
            },

            selectAllOptions() {
                if (this.selectAll) {
                    this.value = this.data.map(item => item.key);
                    this.onlySelected = false;
                    this.options = this.data;
                } else {
                    this.value = [];
                }
            },

            toggleListboxVisibility() {
                if (this.open) return this.closeListbox();
                this.open = true;
                this.$nextTick(() => {
                    this.$refs.search.focus()
                });
            },
        }
    }; 


    var templateFunc = function (config) {
        if (me = findMe(config.whoami)) {
            me.data = config.data;
            me.init();
            return me;
        } else {
            data = mergeConfig(dataTemplate(), config);
            return data;
        }
    };

   window.addEventListener('search-dropdown-ready', function(e) {
       var name = e.detail;
       console.log('create ' + name);
       if (!window[name]) {
            console.log('created ' + name);
            window[name] = templateFunc.bind({});
       }
   });

})();

