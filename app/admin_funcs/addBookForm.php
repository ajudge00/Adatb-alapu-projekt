<form action="admin_funcs/addBook.php" method="post">
    <label for="title_input"> Cím </label> <br>
    <input type="text" name="title" id="title_input"> <br>
    <label for="author_select"> Szerző </label> <br>
    <select name='author' id="author_select">
        <option value="test1"> teszt1 </option>
        <option value="test2"> teszt2 </option>
    </select> <br>
    <button type="submit" class="btn btn-success">Hozzáadás</button>
</form>