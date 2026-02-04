import { useForm } from '@inertiajs/react';

export default function Create({ accounts, categories }) {
    const { data, setData, post, processing, errors } = useForm({
        account_id: '',
        category_id: '',
        type: 'expense',
        amount: '',
        transaction_date: '',
        notes: '',
    });

    function submit(e) {
        e.preventDefault();
        post(route('transactions.store'));
    }

    return (
        <div style={{ padding: '2rem' }}>
            <h1>Add Transaction</h1>

            <form onSubmit={submit}>
                <div>
                    <label>Account</label>
                    <select
                        value={data.account_id}
                        onChange={e => setData('account_id', e.target.value)}
                    >
                        <option value="">Select</option>
                        {accounts.map(a => (
                            <option key={a.id} value={a.id}>{a.name}</option>
                        ))}
                    </select>
                    {errors.account_id && <div>{errors.account_id}</div>}
                </div>

                <div>
                    <label>Type</label>
                    <select
                        value={data.type}
                        onChange={e => setData('type', e.target.value)}
                    >
                        <option value="expense">Outflow</option>
                        <option value="inflow">Inflow</option>
                    </select>
                </div>

                <div>
                    <label>Category</label>
                    <select
                        value={data.category_id}
                        onChange={e => setData('category_id', e.target.value)}
                    >
                        <option value="">Select</option>
                        {categories
                            .filter(c => c.kind === data.type)
                            .map(c => (
                                <option key={c.id} value={c.id}>{c.name}</option>
                            ))}
                    </select>

                    {errors.category_id && <div>{errors.category_id}</div>}
                </div>

                <div>
                    <label>Amount</label>
                    <input
                        type="number"
                        step="0.01"
                        value={data.amount}
                        onChange={e => setData('amount', e.target.value)}
                    />
                    {errors.amount && <div>{errors.amount}</div>}
                </div>

                <div>
                    <label>Date</label>
                    <input
                        type="date"
                        value={data.transaction_date}
                        onChange={e => setData('transaction_date', e.target.value)}
                    />
                    {errors.transaction_date && <div>{errors.transaction_date}</div>}
                </div>

                <div>
                    <label>Notes</label>
                    <textarea
                        value={data.notes}
                        onChange={e => setData('notes', e.target.value)}
                    />
                </div>

                <button disabled={processing}>Save</button>
            </form>
        </div>
    );
}
