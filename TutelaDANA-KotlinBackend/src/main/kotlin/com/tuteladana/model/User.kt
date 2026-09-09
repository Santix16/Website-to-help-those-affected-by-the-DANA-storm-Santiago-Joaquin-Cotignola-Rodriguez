package com.tuteladana.model

import kotlinx.serialization.Serializable

@Serializable
data class User(
    val id: Int? = null,
    val nombre: String,
    val email: String,
    val password: String,
    val tonkens: Int = 0,
    val fechaRegistro: String? = null
)
