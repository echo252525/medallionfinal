<style>
/* DARK MODE */
body.dark table {
    background-color: var(--light);
    color: var(--dark);
}

body.dark table th,
body.dark table td {
    background-color: var(--light);
    color: var(--dark);
    border: 1px solid var(--grey);
}

/* DARK MODE */

/* Include your aesthetic table CSS here */

h2 {
    font-weight: 700;
    color: #2a2a72;
    margin: 0;
}

.table-container {
    background: white;
    padding: 20px 24px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(43, 54, 69, 0.07);
    margin-bottom: 40px;
    overflow-x: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
    min-width: 600px;
}

thead {
    background-color: #2a2a72;
    color: #fff;
}

thead th {
    padding: 14px 20px;
    text-align: left;
    font-weight: 600;
    font-size: 0.95rem;
}

tbody tr {
    border-bottom: 1px solid #dde3eb;
    transition: background-color 0.3s ease;
}

tbody tr:nth-child(even) {
    background-color: #f9fbfc;
}

tbody tr:hover {
    background-color: #e1e5ff;
    cursor: default;
}

tbody td {
    padding: 12px 20px;
    font-size: 0.9rem;
}

.event-picture {
    width: 60px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
}

.event-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 16px;
}

.btn-add-event {
    background-color: #2a2a72;
    color: white;
    border: none;
    padding: 10px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-add-event:hover {
    background-color: #4040a1;
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
</style>