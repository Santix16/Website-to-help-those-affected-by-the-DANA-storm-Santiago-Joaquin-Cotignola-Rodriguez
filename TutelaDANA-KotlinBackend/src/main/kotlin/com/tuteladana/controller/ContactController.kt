package com.tuteladana.controller

import com.tuteladana.model.ContactMessage
import com.tuteladana.repository.ContactRepository
import io.ktor.http.HttpStatusCode
import io.ktor.server.application.call
import io.ktor.server.request.receive
import io.ktor.server.response.respond
import io.ktor.server.routing.Route
import io.ktor.server.routing.post

object ContactController {
    private val contactRepository = ContactRepository

    fun register(route: Route) {
        route.post("/contact") {
            val message = call.receive<ContactMessage>()
            val id = contactRepository.create(message)
            call.respond(HttpStatusCode.Created, mapOf("id" to id, "message" to "Mensaje enviado"))
        }
    }
}
