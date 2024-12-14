<!-- resources/js/components/LoginForm.vue -->
<template>
<div class="wrapper">
    <h1 style="text-align: center;">Login</h1>
    <form @submit.prevent="submitForm">
        
        <div class="input-box">
            <input type="text" v-model="form.username" placeholder="Username" required />
        </div>
       
        <div class="input-box">
            <input type="password" v-model="form.password" placeholder="password" required />
        </div>
        <div class="policy">
            <a href="/signup">creat acount</a>
        </div>
    
        <div class="input-box button">
            <input type="submit" value="Login" />
        </div>
    </form>
    </div>  
</template>

<script>
import axios from 'axios';


export default {
    data() {
        return {
            form: {
                username: '',
                password: '',
               
            },
        };
    },
    methods: {
        
        submitForm() {
            console.log(this.form);
            
            axios.post('/login', this.form)
                .then(response => {

                    
                    
                    // Handle successful registration
                    
                    alert('login succed successful!\n');
                    console.log(response.data.user.name);
                    
                    
                    window.location.href = '/app?name='+this.form.username;
                })
                .catch(error => {
                    console.log(error.response.data);
                    if (error.response.data.message === 'Email or password are wrong'){
                        alert(error.response.data.message);
                    }

                    if (error.response && error.response.data) {

                        // If the error is from the backend, extract the error messages
                        const errorMessages = error.response.data.errors;

                        // Displaying the error messages as an alert
                        let errorMessage = 'Error:\n';
                        for (const [field, messages] of Object.entries(errorMessages)) {
                            errorMessage += ` ${messages.join(', ')}\n`;
                        }
                        alert(errorMessage); // Show all the error messages
                    } else {
                        // If no specific error response, show a generic message
                        alert('An error occurred while processing your request.');
                        
                    }
                });
}

    },
};
</script>
<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    }
    body{
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #4070f4;
    }
    .wrapper{
    position: relative;
    max-width: 430px;
    width: 100%;
    background: #fff;
    padding: 34px;
    border-radius: 6px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .wrapper h2{
    position: relative;
    font-size: 22px;
    font-weight: 600;
    color: #333;
    }
    .wrapper h2::before{
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    height: 3px;
    width: 28px;
    border-radius: 12px;
    background: #4070f4;
    }
    .wrapper form{
    margin-top: 30px;
    }
    .wrapper form .input-box{
    height: 52px;
    margin: 18px 0;
    }
    form .input-box input{
    height: 100%;
    width: 100%;
    outline: none;
    padding: 0 15px;
    font-size: 17px;
    font-weight: 400;
    color: #333;
    border: 1.5px solid #C7BEBE;
    border-bottom-width: 2.5px;
    border-radius: 6px;
    transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box input:valid{
    border-color: #4070f4;
    }
    form .policy{
    display: flex;
    align-items: center;
    }
    form h3{
    color: #707070;
    font-size: 14px;
    font-weight: 500;
    margin-left: 10px;
    }
    .input-box.button input{
    color: #fff;
    letter-spacing: 1px;
    border: none;
    background: #4070f4;
    cursor: pointer;
    }
    .input-box.button input:hover{
    background: #0e4bf1;
    }
    form .text h1{
    color: #333;
    width: 100%;
    text-align: center;
    }
    form .text h3 a{
    color: #4070f4;
    text-decoration: none;
    }
    form .text h3 a:hover{
    text-decoration: underline;
    }
</style>
