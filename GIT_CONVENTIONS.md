# Git Commit Conventions

To maintain a clean, readable, and traceable project history, all contributors are required to follow these commit message guidelines.

---

## 1. The Subject Line (The "What")

The subject line is the first line of the commit message. It must be concise and follow the imperative style.

### The Imperative Mood
Always write the subject as a command. 
* ✅ **Correct:** `PROJ-123 feat: Add user authentication`
* ❌ **Incorrect:** `Added user authentication` or `User auth added`

*Rule:* "If applied, this commit will **[Subject Line]**."

### Structure
We follow a variation of the Conventional Commits specification:
`[JIRA-ID] <type>: <subject>`

| Type | Description |
| :--- | :--- |
| `feat` | A new feature for the user. |
| `fix` | A bug fix. |
| `docs` | Documentation only changes. |
| `refactor` | Code changes that neither fix a bug nor add a feature. |
| `test` | Adding missing tests or correcting existing tests. |
| `chore` | Maintenance tasks (build process, dependencies, etc.). |

---

## 2. The Message Body

The body is separated from the subject by a single **empty line**. It provides depth to the commit.

### When to use Text (Paragraphs)
Use paragraphs to explain the **Context (The "Why")**. 
* Explain why the change was necessary.
* Document architectural decisions or trade-offs.

### When to use Lists (Bullet Points)
Use bullet points to list **Technical Details (The "What")**.
* Ideal for refactors or commits affecting multiple files.
* Use imperative verbs for each point (e.g., "- Add...", "- Remove...").

---

## 3. Formatting Standards

* **Length:** Keep the subject line under 50 characters. 
* **Wrapping:** Wrap the body at 72 characters for better terminal readability.
* **Separation:** Always use a blank line between the subject and the body.
* **Punctuation:** Do not end the subject line with a period.

---

## 4. Examples

### Refactor with mixed Body

```text
PROJ-124 refactor: Centralize configuration and setup

To improve maintainability and support containerized environments, 
we are moving hard-coded values into a dedicated config file.

- Create ./config.php with an $app array for environment data.
- Add setupEnvironment() method to App\Administrator class.
- Update bin/users_create.php to utilize the new configuration.
```

### Simple Bugfix with Context

```text
PROJ-89 fix: Remove default exchange fallback

The previous hard-coded fallback prevented the application from 
using the unnamed AMQP default exchange. This change ensures 
compliance with the AMQP standard where an empty string targets 
the default exchange.
```

## 5. Summary Checklist

1. Is the Jira ID included?
2. Is the type (feat, fix, etc.) correct?
3. Is the subject in the imperative mood?
4. Is there a blank line before the body?
5. Does the body explain why and what clearly?