(function() {
    var templateFunc = function (config) {
        console.log(config)
        return {
            data: config.data,

            emptyOptionsMessage: config.emptyOptionsMessage,

            name: config.name,

            open: false,

            selectAll: false,

            onlySelected: false,

            options: [],

            placeholder: config.placeholder,

            search: '',

            multiselect: config.multiselect,

            entangle: config.entangle,

            context: config.context,

            whoami: config.whoami,

            value: this.multiselect ? (config.value ?? []) : config.value,

            closeListbox: function () {
                this.open = false;
                this.search = '';
            },

            init: function () {
                me = this;
                this.options = this.data;
                console.log(this.options.map(item => { return { key: (item.key + ''), value: (item.value + '') } }));
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
                    console.log(livewireParent ? livewireParent : ('no lvw for context ' + this.context));
                    this.$watch('value', (updateValue) => {
                        console.log('value updated ' + updateValue)
                        console.log(me.entangle);
                        livewireParent.set(me.entangle, updateValue);
                    });
                }
            },
            selectOption: function (selectedValue) {
                if (!this.open) return this.toggleListboxVisibility();

                if(!this.multiselect){
                    if (this.value && selectedValue === this.value) {
                        this.value = null;
                    } else {
                        this.value = selectedValue;
                    }
                    this.closeListbox();
                } else {
                    if(this.value.includes(selectedValue)){
                        this.value.splice(this.value.indexOf(selectedValue), 1);
                    }else{
                        this.value.push(selectedValue);
                    }
                    if(this.onlySelected){
                        this.showOnlySelectedOptionsInList();
                    }
                    if (this.value.length != this.data.length && this.selectAll) {
                        this.selectAll = false;
                    }
                }

            },
            shouldShowDisplaySelectedOptions()
            {
                return this.multiselect && this.value.length && this.value.length != this.data.length;
            },
            showSelectedOptions: function() {
                if (this.value.length === 0) return this.placeholder;
                return this.value.map(value => this.options[value]).join(',');
            },
            showOnlySelectedOptionsInList: function () {
                this.search='';
                if(!this.value.length){
                    this.onlySelected = false;
                }
                if (this.onlySelected){
                    this.options = this.data.filter(item => this.value.includes(item.key))
                } else {
                    this.options = this.data;
                }
            },
            selectAllOptions: function () {
                if (this.selectAll) {
                    this.value = this.data.map(item=>item.key);
                    this.onlySelected = false;
                    this.options = this.data;
                } else {
                    this.value = [];
                }
            },
            toggleListboxVisibility: function () {
                if (this.open) return this.closeListbox();
                this.open = true;
                this.$nextTick(() => {
                    this.$refs.search.focus()
                });
            },
        }
   };
   window.addEventListener('search-dropdown-ready', function(e) {
       var name = e.detail;
       console.log(e,name , window[name]);
       window[name] = templateFunc.bind({});
   });
})();

