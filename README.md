# Projeto de Estudo com Laravel e Vue

Este repositório é dedicado a um estudo prático sobre o **framework Laravel** e sua integração com **Vue.js** para construção de aplicações web modernas.  
O objetivo é aprender e experimentar recursos como rotas, controllers, validações, consumo de API e front-end dinâmico.

---

## 🚀 Tecnologias utilizadas
- **Laravel 12** – Framework PHP para desenvolvimento backend
- **Vue 3** – Framework JavaScript para construção de interfaces reativas
- **Vite** – Ferramenta de build moderna para integração rápida entre Laravel e Vue
- **TailwindCSS** – Framework CSS utilitário para estilização
- **MySQL** – Banco de dados relacional

---

## 📂 Estrutura do projeto
- `routes/api.php` → Rotas da API (ex.: `/api/pessoas`)
- `app/Http/Controllers/PessoaController.php` → Controller responsável por CRUD de pessoas
- `resources/views/pessoas.blade.php` → View Blade que integra Vue
- `resources/js/components/Pessoas.vue` → Componente Vue para listar e cadastrar pessoas
- `public/storage/fotos` → Pasta para armazenar imagens enviadas em base64

---

## 📌 Funcionalidades implementadas
- Listagem de pessoas cadastradas
- Cadastro de novas pessoas via formulário Vue
- Validações no backend (Laravel) com retorno em JSON
- Exibição de mensagens de erro no frontend
- Upload de foto em base64 e armazenamento no `storage/public`

---

## ▶️ Como rodar o projeto
1. Clone este repositório:
   ```bash
   git clone https://github.com/seu-usuario/pessoa-project.git

   composer install

   npm install

   php artisan migrate

   php artisan serve

   npm run dev