/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

try {
    window.$ = window.jQuery = require('jquery');

} catch (e) {}

window.Vue = require('vue');

Vue.component('Lesson', require('./components/LessonNotification.vue').default);


window.onload = function () {
    const app = new Vue({
        el: '#app',
        data:{
            'lessons':[],
        },
        created(){
                if(window.Laravel.userId){
                    axios.get('/notification/lesson/notification').then(response => {
                        this.lessons = response.data;
                        console.log(response.data)
                    });
    
    
                    Echo.private(`App.User.${window.Laravel.userId}`)
                        .notification((notification) => {
                            console.log(notification.type);
                                   data= {"data":notification};
    
                             this.lessons.push(data);
                         
                            let type  =  (notification.type).toString();

                            var ar = type.split("\\");

                         
                              console.log(ar)


                              $('.countNotibadge').html(notification.count);
                              if(ar[2] == "TaskNotifications"){
                                  console.log(notification.count);
                                  alert(notification.lesson[0]['title'])
                              }else  if(ar[2] == "NewLessonNotification"){
                                alert(notification.lesson[0]['title'])
                              }else{
                                alert(notification.lesson[0]['title'])
                              }
                              //  this.lessons.push(data);


                        });
    
                    // Echo.private('App.User.'+window.Laravel.userId).notification((response) => {
                    //     data= {"data":response};
    
                    //    this.lessons.push(data);
                    //    console.log(data)
                    // })
    
    
    
                    // Echo.private(`App.User.${window.Laravel.userId}`)
                    //     .notification((notification) => {
                    //         console.log(notification.type);
                    //     });
                }
        }
    });
}

