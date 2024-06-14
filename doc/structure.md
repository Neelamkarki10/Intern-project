> Documentation shall be done in [Markdown](https://www.markdownguide.org/cheat-sheet/)

# Directory Structure

- ".template/" is for raw HTML file before converting it to corresponding php file
- "api/" is for php files that are used for responding API calls
- "doc/" is for documentation
- "page/" is for pages other than 'index.php'
- "res/" is for CSS, Javascript, Image and other resources
- "src/" is for utility php files that will not be rendered
- "test/" is for php files used for automating tests

# CSS Structure

- 'theme.css' contains global properties that have to be consistent across the project
- use 'name-of-webpage.css' to define properties that are local to each page
- local css files shall follow the following hierarchy
  1. margin
  2. border
  3. border-radius
  4. padding
  5. display
     - display properties
  6. height
  7. width
     - other properties
  8. color
  9. background-color
