# 📚 Notes de Frais API Documentation

> **Base URL**: `http://localhost:8000/api`  
> **Authentication**: Token-based (Laravel Sanctum)

---

## 🔐 Authentication

### ➕ Login
**POST** `/api/login`  
**Request:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```
**Response:**
```json
{
  "token": "your_auth_token"
}
```

### 🔓 Logout
**POST** `/api/logout`  
**Headers:** `Authorization: Bearer {token}`

### 👤 Get Current User
**GET** `/api/user`  
**Headers:** `Authorization: Bearer {token}`

---

## 📒 Notes de Frais

### 📄 List Notes
**GET** `/api/notes`

### ➕ Create Note
**POST** `/api/notes`  
**Form Data:**
- `date_depense`: (date, required)
- `categorie`: `repas | hôtel | transport`
- `montant`: (numeric)
- `devise`: (3-letter code)
- `description`: (optional)
- `fichier_justificatif`: (file)

### ✏️ Update Note
**PUT** `/api/notes/{id}`

### ❌ Delete Note
**DELETE** `/api/notes/{id}`

### 📤 Submit Note
**POST** `/api/notes/{id}/soumettre`

### ✅ Validate Note
**POST** `/api/notes/{id}/valider`  
**Body:**
```json
{ "commentaire": "Validée OK" }
```

### ❌ Reject Note
**POST** `/api/notes/{id}/rejeter`  
**Body:**
```json
{ "commentaire": "Justificatif manquant" }
```

### 💸 Mark Note as Reimbursed
**POST** `/api/notes/{id}/rembourser`

---

## 🚗 Déplacements

### 📄 List Deplacements
**GET** `/api/deplacements`

### ➕ Create Deplacement
**POST** `/api/deplacements`  
**Body:**
```json
{
  "objet": "Conférence",
  "lieu": "Rabat",
  "date_depart": "2025-07-10",
  "date_retour": "2025-07-12",
  "moyen_transport": "train",
  "cout_estime": 300
}
```

### ✅ Validate Deplacement
**POST** `/api/deplacements/{id}/valider`

### ❌ Reject Deplacement
**POST** `/api/deplacements/{id}/rejeter`  
**Body:**
```json
{ "commentaire": "Pas de budget" }
```

---

## 🔔 Notifications

### 🔄 Get Notifications
**GET** `/api/notifications`

### ☑️ Mark Notification as Read
**POST** `/api/notifications/{id}/mark-as-read`

---
()
## 📁 Justificatifs

### 📥 Download File
**GET** `/api/justificatif/{filename}`

Example:
`/api/justificatif/justificatifs/test.pdf`

---

## 📊 Dashboard

**GET** `/api/dashboard`  
Returns data based on authenticated user role.