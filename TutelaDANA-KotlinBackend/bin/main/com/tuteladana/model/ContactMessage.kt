package com.tuteladana.model

import kotlinx.serialization.Serializable

@Serializable
data class ContactMessage(
    val id: Int? = null,
    val nombre: String,
    val email: String,
    val mensaje: String,
    val fechaEnvio: String? = null
)
