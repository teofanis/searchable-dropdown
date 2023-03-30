function findMe(name)
{
    var myEl = document.querySelectorAll('[x-ref="' + name + '"]')[0];
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
                this.setup = true;
                this.options = this.data;
                if (this.context && this.entangle) {
                    var livewireParent = window.livewire.find(this.context);
                    this.value = livewireParent.get(this.entangle);
                    this.$watch('value', (updateValue) => {
                        livewireParent.set(this.entangle, updateValue);
                    });
                }
                if (this.multiselect) {
                    this.value = this.options.filter(item => this.value.includes(item.key)).map(item => item.key);
                } else {
                    if (!this.options.filter(item => this.value == item.key)) this.value = null;
                }

                this.$watch('value', (updatedValue) => {
                    let selector = this.whoami + '_input';
                    const input = document.getElementById(selector);
                    if (input) {
                        input.value = updatedValue;
                        let event = new Event('change');
                        input.dispatchEvent(event);
                    }
                });

                this.$watch('search', ((value) => {
                    this.options = this.data.filter((item) => item.value.toLowerCase().includes(value.toLowerCase()))
                }))


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
                        this.value = this.value.filter(value => value !== selectedValue);
                    } else {
                        this.value = this.value.concat(selectedValue);
                    }
                    if (this.onlySelected) {
                        this.showOnlySelectedOptionsInList();
                    }
                    if (this.value.length != this.data.length && this.selectAll) {
                         this.selectAll = false;
                    } else if (this.value.length == this.data.length && !this.selectAll) {
                        this.selectAll = true;
                    }
                }
            },

            shouldShowDisplaySelectedOptions() {
                return this.multiselect && this.value.length && this.value.length != this.data.length;
            },

            showSelectedOptions: function () {
                if (this.value.length === 0) return this.placeholder;
                return this.options.filter(option => this.value.includes(option.key)).map(option => option.value);
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
            isGrouped(item) {
                if (!item) return false;
                const myItem = { ...item };
                let isGrouped = false;
                try {
                    isGrouped = (myItem.key && myItem.key.includes('optgroup'));
                } catch (e) {
                    return false;
                }
                return isGrouped;
            },
            toggleListboxVisibility() {
                if (this.open) return this.closeListbox();
                this.open = true;
                this.$nextTick(() => {
                    this.$refs.search.focus()
                });
            },

            hasValidValue() {
                if (this.multiselect) {
                    return this.options.filter(item => this.value.includes(item.key)).length;
                } else {
                    return this.options.filter(item => this.value == item.key).length;
                }
            },

            valueText() {
                item = this.options.filter(item => this.value == item.key)[0];
                return item ? item.value : false;
            },

            getButtonText() {
                return  this.hasValidValue() ? this.valueText() : this.placeholder;
            }

        }
    };


    var templateFunc = function (config) {
        if (me = findMe(config.whoami)) {
            me.data = config.data;
            me.value = config.value;
            me.init();
            return me;
        } else {
            data = mergeConfig(dataTemplate(), config);
            return data;
        }
    };

   window.addEventListener('search-dropdown-ready', function(e) {
       var name = e.detail;
       if (!window[name]) {
            window[name] = templateFunc.bind({});
       }
   });

})();

