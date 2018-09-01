import Vue from 'vue';
import  moment  from 'moment'


 Vue.filter('uppercase', function(text){
    return text.toUpperCase() ;
})

Vue.filter('lowercase', function(text){
    return text.toLowerCase() ;
})

Vue.filter('capitalize', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1) ;
})

Vue.filter('date', function(date){
    return moment(date).format('MMMM Do YYYY') ;
})

