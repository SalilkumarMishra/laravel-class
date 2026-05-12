<form action = "/submit-form" method ="post">
@csrf
    Username: <input type = "text" name = "username">
    <br><br>
    Email: <input type = "text" name = "email">
    <br><br>
    <button type = "submit" value = "Submit">
        Submit
    </button>
</form>