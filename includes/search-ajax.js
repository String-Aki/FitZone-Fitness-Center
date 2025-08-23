document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".search-input");
  const suggestionsContainer = document.querySelector(".search-suggestions");
  const SearchContainer = document.querySelector(".search-container");

  const currentUID = SearchContainer.dataset.uid;
  const currentRole = SearchContainer.dataset.role;

  let apiUrl;

  searchInput.addEventListener("input", function () {
    const query = this.value.trim();
    if (query.length < 2) {
      suggestionsContainer.style.display = "none";
      return;
    }

    if (currentRole == 'staff') {
      apiUrl = "../../includes/search-api.php";
    } else if (currentRole == "customer") {
      apiUrl = "../../../includes/search-api.php";
    } else {
      apiUrl = "../../../includes/search-api.php";
    }

    fetch(
      `${apiUrl}?uid=${currentUID}&query=${query}&role=${currentRole}`
    )
      .then((response) => response.json())
      .then((data) => {
        suggestionsContainer.innerHTML = "";
        if (data.length > 0) {
          data.forEach((item) => {
            console.log(item.name)
            const div = document.createElement("div");
            div.className = "suggestion-item";
            div.innerHTML = `<span>${item.name}</span> <span class="type">${item.type}</span>`;
            div.onclick = function () {
              window.location.href = item.url;
            };
            suggestionsContainer.appendChild(div);
          });
          suggestionsContainer.style.display = "block";
        } else {
          suggestionsContainer.style.display = "none";
        }
      })
      .catch((error) => console.error("Search error:", error));
  });

  document.addEventListener("click", function (event) {
    if (!searchInput.contains(event.target)) {
      suggestionsContainer.style.display = "none";
    }
  });
});
