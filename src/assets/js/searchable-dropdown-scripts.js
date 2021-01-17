(function() {
    var templateFunc =  function(config) {
       return {
           data: config.data,

           emptyOptionsMessage: config.emptyOptionsMessage,

           name: config.name,

           open: false,

           selectAll: false,

           onlySelected: false,

           options: {},

           placeholder: config.placeholder,

           search: '',

           multiselect: config.multiselect,

           entangle: config.entangle,

           context: config.context,

           value: this.multiselect ? (config.value ?? []) : config.value,

           closeListbox: function () {
               this.open = false;
               this.search = '';
           },

           init: function () {
               this.options = this.data;

               if (this.multiselect) {
                   this.value = Object.keys(this.options).filter(entry => this.value.includes(entry));

               } else {
                   if (!(this.value in this.options)) this.value = null;
               }
               this.$watch('search', ((value) => {

                    this.options = Object.keys(this.data)
                       .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                       .reduce((options, key) => {
                           options[key] = this.data[key]
                           return options
                       }, {});

               }))


               var that = this;

               console.log(this.value);
               console.log(this.options);
               if(this.context && this.entangle){
                   var livewireParent =  window.livewire.find(that.context);
                   //this.value = livewireParent.get(this.entangle);
                   this.$watch('value', ((value) => {
                       console.log(Object.values(value));
                      //livewireParent.set(that.entangle, Object.values(value));
                   }));
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
                   if (this.value.length != Object.keys(this.data).length && this.selectAll) {
                       this.selectAll = false;
                   }
               }

           },
           shouldShowDisplaySelectedOptions()
           {
               return this.multiselect && this.value.length && this.value.length != Object.keys(this.data).length;
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
                   this.options = Object.keys(this.data)
                   .filter(key => this.value.includes(key))
                   .reduce((options, key) => {
                       options[key] = this.data[key];
                       return options;
                   }, {});
               } else {
                   this.options = this.data;
               }
           },
           selectAllOptions: function () {
               if (this.selectAll) {
                   this.value = Object.keys(this.data);
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
       window[name] = templateFunc.bind({});
   });
})();
