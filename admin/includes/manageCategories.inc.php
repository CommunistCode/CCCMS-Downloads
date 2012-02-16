<form action='manageDownloadCategories.php' method='post'>

  <label for="name">Category Name:</label>
  <input type='text' name='name' />

  <label for="parentCategory">Parent Category</label>
  <select name='parentCategory'>

    <option value='0'>Main Category</option>

    <?php $downloadTools->renderCategorySelectOptions(); ?>
  
  </select>
  
  <input type='submit' value='Add Category' name='addCategory' />

</form>

<form action='manageDownloadCategories.php' method='post'>

  <label for="categoryID">Category Name:</label>
  <select name='categoryID'>

    <?php $downloadTools->renderCategorySelectOptions(); ?>

  </select>

  <input type='submit' value='Delete Category' name='deleteCategory' />

</form>
