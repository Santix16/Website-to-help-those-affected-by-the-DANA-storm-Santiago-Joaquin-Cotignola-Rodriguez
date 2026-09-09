package com.tuteladana.model

import kotlinx.serialization.Serializable

@Serializable
data class Product(
    val id: Int? = null,
    val nombre: String,
    val precioTonkens: Int,
    val descripcion: String? = null
)
