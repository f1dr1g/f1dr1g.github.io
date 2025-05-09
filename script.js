// Сокращенный массив статей (только необходимые поля)
const articles = [
  {
    id: 1,
    title: "Основы JavaScript",
    category: "programming",
    excerpt: "JavaScript — это мультипарадигменный язык программирования.",
    content: `
      <p>JavaScript — это мультипарадигменный язык программирования. Поддерживает объектно-ориенти��ованный, императивный и функциональный стили.</p>
      
      <p>Вот пример простой функции в JavaScript:</p>
      <code>
function greet(name) {
  return \`Привет, \${name}!\`;
}

console.log(greet('Мир')); // Выведет: Привет, Мир!
      </code>
      
      <div class="diagram">
        <h4 class="diagram__title">Жизненный цикл JavaScript</h4>
        <div class="diagram__content">
          <p>1. Создание глобального контекста выполнения</p>
          <p>2. Фаза создания (hoisting)</p>
          <p>3. Фаза выполнения</p>
          <p>4. Сборка мусора</p>
        </div>
      </div>
      
      <p>JavaScript широко используется для создания интерактивных веб-страниц и является неотъемлемой частью веб-приложений.</p>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">О шаблонных строках</h5>
          <p class="explanation__content">В примере выше используются шаблонные строки (template literals) с обратными кавычками (\`). Это современный способ создания строк в JavaScript, который позволяет вставлять переменные непосредственно в строку с помощью синтаксиса \${переменная}.</p>
        </div>
        <div class="explanation">
          <h5 class="explanation__title">Hoisting (поднятие)</h5>
          <p class="explanation__content">Hoisting — это механизм JavaScript, при котором объявления переменных и функций "поднимаются" в начало их области видимости перед выполнением кода. Например, функцию <code>greet()</code> можно вызвать до её объявления, и это будет работать.</p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Какой оператор используется для строгого сравнения в JavaScript?",
          options: ["==", "===", "=", "!="],
          correctAnswer: 1,
        },
        {
          question: "Что выведет console.log(typeof []);?",
          options: ["array", "object", "undefined", "null"],
          correctAnswer: 1,
        },
      ],
    },
  },
  {
    id: 2,
    title: "HTML5 и семантические теги",
    category: "programming",
    excerpt: "HTML5 — это последняя версия языка разметки HTML.",
    content: `
      <p>HTML5 — это последняя версия языка разметки HTML, которая вводит новые семантические элементы для лучшей структуризации веб-страниц.</p>
      
      <p>Вот пример использования семантических тегов:</p>
      <code>
<!DOCTYPE html>
<html>
<head>
  <title>Семантический HTML</title>
</head>
<body>
  <header>
    <h1>Мой сайт</h1>
    <nav>
      <ul>
        <li><a href="#">Главная</a></li>
        <li><a href="#">О нас</a></li>
      </ul>
    </nav>
  </header>
  
  <main>
    <article>
      <h2>Заголовок статьи</h2>
      <p>Содержание статьи...</p>
    </article>
  </main>
  
  <footer>
    <p>&copy; 2023 Мой сайт</p>
  </footer>
</body>
</html>
      </code>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">Почему семантика важна</h5>
          <p class="explanation__content">Семантические теги делают код более читаемым и понятным как для разработчиков, так и для браузеров. Например, тег <code>&lt;nav&gt;</code> сразу указывает, что внутри находится навигация, а не просто список ссылок в <code>&lt;div&gt;</code>.</p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Какой тег используется для основного содержимого страницы в HTML5?",
          options: ["<content>", "<body>", "<main>", "<article>"],
          correctAnswer: 2,
        },
      ],
    },
  },
  {
    id: 3,
    title: "Настройка NGINX",
    category: "administration",
    excerpt: "NGINX — это высокопроизводительный веб-сервер и прокси-сервер.",
    content: `
      <p>NGINX — это высокопроизводительный веб-сервер и прокси-сервер с открытым исходным кодом.</p>
      
      <p>Вот пример базовой конфигурации NGINX:</p>
      <code>
server {
  listen 80;
  server_name example.com www.example.com;
  
  location / {
    root /var/www/html;
    index index.html index.htm;
    try_files $uri $uri/ =404;
  }
}
      </code>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">Директива location</h5>
          <p class="explanation__content">В конфигурации NGINX директива <code>location</code> определяет, как обрабатывать запросы к определенным URL. Например, <code>location ~ \\.php$</code> обрабатывает все запросы к PHP-файлам, а <code>location /</code> — все остальные запросы.</p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Какой порт по умолчанию использует HTTP?",
          options: ["8080", "443", "80", "22"],
          correctAnswer: 2,
        },
      ],
    },
  },
  {
    id: 4,
    title: "Docker для начинающих",
    category: "administration",
    excerpt: "Docker — это платформа для разработки, доставки и запуска приложений в контейнерах.",
    content: `
      <p>Docker — это платформа для разработки, доставки и запуска приложений в контейнерах.</p>
      
      <p>Вот пример простого Dockerfile:</p>
      <code>
FROM node:14-alpine
WORKDIR /app
COPY . .
EXPOSE 3000
CMD ["npm", "start"]
      </code>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">Docker Compose</h5>
          <p class="explanation__content">Для управления несколькими контейнерами удобно использовать Docker Compose. Он позволяет определить все сервисы, сети и тома в одном YAML-файле. Пример запуска: <code>docker-compose up -d</code></p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Что такое Docker контейнер?",
          options: [
            "Виртуальная машина",
            "Изолированная среда для запуска приложений",
            "Физический сервер",
            "Операционная система",
          ],
          correctAnswer: 1,
        },
      ],
    },
  },
  {
    id: 5,
    title: "Принципы UI/UX дизайна",
    category: "design",
    excerpt: "UI/UX дизайн — это процесс создания интерфейсов.",
    content: `
      <p>UI/UX дизайн — это процесс создания интерфейсов, которые обеспечивают положительный опыт взаимодействия пользователя с продуктом.</p>
      
      <p>Основные принципы UI/UX дизайна:</p>
      <ul>
        <li>Простота и интуитивность</li>
        <li>Согласованность и стандарты</li>
        <li>Обратная связь</li>
        <li>Предотвращение ошибок</li>
      </ul>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">Разница между UI и UX</h5>
          <p class="explanation__content">UI (User Interface) — это визуальная часть продукта, с которой взаимодействует пользователь. UX (User Experience) — это общий опыт взаимодействия пользователя с продуктом, включая эмоции, удобство и эффективность.</p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Что означает аббревиатура UX?",
          options: ["User Experience", "User Extension", "User Examination", "User Extraction"],
          correctAnswer: 0,
        },
      ],
    },
  },
  {
    id: 6,
    title: "Основы CSS Grid",
    category: "design",
    excerpt: "CSS Grid — это мощная система макетов.",
    content: `
      <p>CSS Grid — это мощная система макетов, которая позволяет создавать двумерные сетки для веб-страниц.</p>
      
      <p>Вот пример использования CSS Grid:</p>
      <code>
.grid-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 20px;
}
      </code>
      
      <div class="explanations">
        <h4 class="explanations__title"><i class="fas fa-lightbulb"></i> Пояснения автора</h4>
        <div class="explanation">
          <h5 class="explanation__title">Единица fr</h5>
          <p class="explanation__content">Единица <code>fr</code> (fraction) в CSS Grid представляет собой долю свободного пространства. Например, <code>grid-template-columns: 1fr 2fr</code> создаст две колонки, где вторая будет в два раза шире первой.</p>
        </div>
      </div>
    `,
    quiz: {
      title: "Проверьте свои знания",
      questions: [
        {
          question: "Какое свойство используется для определения CSS Grid?",
          options: ["display: flex", "display: grid", "display: block", "display: inline-grid"],
          correctAnswer: 1,
        },
      ],
    },
  },
]

// Вспомогательные функции
function getArticleById(id) {
  return articles.find((article) => article.id === Number.parseInt(id))
}

function getArticlesByCategory(category) {
  return articles.filter((article) => article.category === category)
}

function getRandomArticle() {
  const randomIndex = Math.floor(Math.random() * articles.length)
  return articles[randomIndex]
}

function getCategoryIcon(category) {
  const icons = {
    programming: "fa-code",
    administration: "fa-server",
    design: "fa-paint-brush",
  }
  return icons[category] || "fa-file-alt"
}

function getCategoryName(category) {
  const names = {
    programming: "Программирование",
    administration: "Администрирование",
    design: "Дизайн",
  }
  return names[category] || "Категория"
}

// Инициализация страниц
document.addEventListener("DOMContentLoaded", () => {
  // Определяем текущую страницу по URL
  const path = window.location.pathname
  const pageName = path.split("/").pop()

  // Инициализируем соответствующую страницу
  if (pageName === "index.html" || pageName === "") {
    initHomePage()
  } else if (pageName === "article.html") {
    initArticlePage()
  } else if (["programming.html", "administration.html", "design.html"].includes(pageName)) {
    const category = pageName.replace(".html", "")
    initCategoryPage(category)
  }

  // Добавляем обработчик для кнопки случайной статьи на всех страницах
  const randomArticleBtn = document.getElementById("randomArticleBtn")
  if (randomArticleBtn) {
    randomArticleBtn.addEventListener("click", () => {
      const randomArticle = getRandomArticle()
      window.location.href = `article.html?id=${randomArticle.id}`
    })
  }
})

// Инициализация домашней страницы
function initHomePage() {
  const featuredArticlesEl = document.getElementById("featuredArticles")
  if (!featuredArticlesEl) return

  // Показываем 4 случайные статьи
  const shuffledArticles = [...articles].sort(() => 0.5 - Math.random()).slice(0, 4)

  shuffledArticles.forEach((article) => {
    const articleEl = document.createElement("div")
    articleEl.className = "featured-article"
    articleEl.innerHTML = `
      <div class="featured-article__content">
        <span class="featured-article__category">${getCategoryName(article.category)}</span>
        <h3 class="featured-article__title">${article.title}</h3>
        <p class="featured-article__excerpt">${article.excerpt}</p>
        <a href="article.html?id=${article.id}" class="featured-article__link">
          Читать далее <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    `

    featuredArticlesEl.appendChild(articleEl)
  })
}

// Инициализация страницы категории
function initCategoryPage(category) {
  const articlesListEl = document.getElementById("articlesList")
  if (!articlesListEl) return

  // Получаем статьи для этой категории
  const categoryArticles = getArticlesByCategory(category)

  // Отображаем статьи
  categoryArticles.forEach((article) => {
    const articleEl = document.createElement("div")
    articleEl.className = "article-card"
    articleEl.innerHTML = `
      <div class="article-card__content">
        <h3 class="article-card__title">${article.title}</h3>
        <p class="article-card__excerpt">${article.excerpt}</p>
        <a href="article.html?id=${article.id}" class="article-card__link">
          Читать далее <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    `

    articlesListEl.appendChild(articleEl)
  })
}

// Инициализация страницы статьи
function initArticlePage() {
  const articleTitleEl = document.getElementById("articleTitle")
  const articleContentEl = document.getElementById("articleContent")
  const articleMetaEl = document.getElementById("articleMeta")
  const articleQuizEl = document.getElementById("articleQuiz")

  if (!articleTitleEl || !articleContentEl) return

  // Получаем ID статьи из URL
  const urlParams = new URLSearchParams(window.location.search)
  const articleId = urlParams.get("id")

  if (!articleId) {
    window.location.href = "index.html"
    return
  }

  // Получаем статью
  const article = getArticleById(articleId)

  if (!article) {
    window.location.href = "index.html"
    return
  }

  // Обновляем заголовок страницы
  document.title = `${article.title} - IT Knowledge Base`

  // Обновляем содержимое статьи
  articleTitleEl.textContent = article.title
  articleContentEl.innerHTML = article.content

  // Обновляем мета-информацию
  if (articleMetaEl) {
    articleMetaEl.innerHTML = `
      <a href="${article.category}.html">
        <i class="fas ${getCategoryIcon(article.category)}"></i> ${getCategoryName(article.category)}
      </a>
    `
  }

  // Создаем викторину
  if (articleQuizEl && article.quiz) {
    createQuiz(article.quiz, articleQuizEl)
  }
}

// Создание викторины
function createQuiz(quiz, quizEl) {
  let quizHTML = `
    <div class="quiz">
      <h3 class="quiz__title">${quiz.title}</h3>
  `

  quiz.questions.forEach((question, qIndex) => {
    quizHTML += `
      <div class="quiz__question" data-index="${qIndex}">
        <p><strong>Вопрос ${qIndex + 1}:</strong> ${question.question}</p>
        <div class="quiz__options">
    `

    question.options.forEach((option, oIndex) => {
      quizHTML += `
        <label class="quiz__option" data-index="${oIndex}">
          <input type="radio" name="question-${qIndex}" value="${oIndex}">
          ${option}
        </label>
      `
    })

    quizHTML += `
        </div>
        <div class="quiz__result" style="display: none;"></div>
      </div>
    `
  })

  quizHTML += `
      <button class="button button--quiz" id="checkQuizBtn">Проверить ответы</button>
    </div>
  `

  quizEl.innerHTML = quizHTML

  // Добавляем обработчик для кнопки проверки
  document.getElementById("checkQuizBtn").addEventListener("click", () => {
    checkQuizAnswers(quiz)
  })
}

// Проверка ответов викторины
function checkQuizAnswers(quiz) {
  let correctAnswers = 0

  quiz.questions.forEach((question, qIndex) => {
    const questionEl = document.querySelector(`.quiz__question[data-index="${qIndex}"]`)
    const selectedOption = questionEl.querySelector('input[type="radio"]:checked')
    const resultEl = questionEl.querySelector(".quiz__result")

    // Сбрасываем предыдущие результаты
    questionEl.querySelectorAll(".quiz__option").forEach((option) => {
      option.classList.remove("quiz__option--correct", "quiz__option--incorrect")
    })

    if (selectedOption) {
      const selectedIndex = Number.parseInt(selectedOption.value)
      const correctIndex = question.correctAnswer

      // Отмечаем правильные и неправильные варианты
      questionEl.querySelector(`.quiz__option[data-index="${correctIndex}"]`).classList.add("quiz__option--correct")

      if (selectedIndex !== correctIndex) {
        questionEl
          .querySelector(`.quiz__option[data-index="${selectedIndex}"]`)
          .classList.add("quiz__option--incorrect")
      }

      // Показываем результат
      resultEl.style.display = "block"
      if (selectedIndex === correctIndex) {
        resultEl.textContent = "Правильно!"
        resultEl.className = "quiz__result quiz__result--correct"
        correctAnswers++
      } else {
        resultEl.textContent = "Неправильно. Правильный ответ выделен зеленым."
        resultEl.className = "quiz__result quiz__result--incorrect"
      }
    } else {
      // Не выбран вариант
      resultEl.style.display = "block"
      resultEl.textContent = "Вы не выбрали ответ."
      resultEl.className = "quiz__result quiz__result--incorrect"

      // Подсвечиваем правильный ответ
      questionEl
        .querySelector(`.quiz__option[data-index="${question.correctAnswer}"]`)
        .classList.add("quiz__option--correct")
    }
  })

  // Показываем общий результат
  const totalQuestions = quiz.questions.length
  alert(`Вы ответили правильно на ${correctAnswers} из ${totalQuestions} вопросов.`)
}
