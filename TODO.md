<!-- # TODO: Fix Login Assets Not Loading

## Step 1: Fix CSS File Location ✅

- [x] Move `resources/css/login.css/login.css` to `resources/css/login.css`
- [x] Delete empty `resources/css/login.css/` folder

## Step 2: Update Vite Config ✅

- [x] Add `resources/css/login.css` to input array
- [x] Add `resources/js/login/login.js` to input array

## Step 3: Update Blade Template ✅

- [x] Replace `{{ asset('css/login.css') }}` with `@vite(['resources/css/login.css', 'resources/js/login/login.js'])`
- [x] Remove separate `<script>` tag for JS

## Step 4: Run Build 🔄

- [ ] Run `npm run dev` or `npm run build` -->
